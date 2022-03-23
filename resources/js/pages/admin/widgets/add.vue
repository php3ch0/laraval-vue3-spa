<template>
  <section>

    <div class="row">
      <div class="col-12 col-lg-6 mb-3 text-center text-lg-start">
        <h1>Widgets</h1>
      </div>
      <div class="col-12 col-lg-6 mb-3 text-center text-lg-end">
        <router-link to="/admin/widgets" class="btn btn-primary">Go Back</router-link>
      </div>
    </div>

    <card title="Add Widget">
      <div v-if="ErrorMessages" class="alert alert-danger mb-3">
        <div v-for="Error in ErrorMessages">
          {{ Error[0] }}
        </div>
      </div>
      <form id="form" class="form" enctype="multipart/form-data">
        <div class="row">
          <div class="col">
            <div class="mb-2">
              <label for="name">Widget Name:</label>
              <input v-model="name" type="text" class="form-control">
            </div>

          </div>
        </div>

        <button v-on:click="doUpdate" type="submit" class="btn btn-primary">Create Widget</button>

      </form>

    </card>
  </section>

</template>

<script>
export default {
  middleware: 'admin',
  layout: 'admin',
  name:'adminWidgetsIndex',

  metaInfo () {
    let self = this;
    return {
      title: 'Admin Portal',
      meta: [
        {name: 'description',content: 'Manage the setting of your website'},
      ]
    }
  },

  data() {
    return {
      thisWidget:null,
      name:null,
      ErrorMessages:null,
    }
  },
  methods: {

    async doUpdate(e) {
      let self = this;
      e.preventDefault();

      self.$axios.post('/api/admin/widgets/add',
              { name: self.name }
      )
              .then(function (res) {
                if(res.data.status=='error') {
                  self.ErrorMessages = res.data.errors;
                } else {
                  self.$router.push({path: '/admin/widgets/'+res.data.id});
                }

              });
    },

  }
}
</script>
