<template>
  <div id="AdminWidgetPage" class="container-fluid">
    <div class="row">
      <div class="col-12 col-lg-8">
        <h1>Manage Widgets</h1>
      </div>
      <div class="col-12 col-lg-4 text-end">
        <router-link to="/admin/widgets/add" class="btn btn-primary">Add Widget</router-link>
      </div>
    </div>


    <div class="card card-default mt-3">
      <div class="card-header">Manage Widgets</div>
      <div class="card-body">
      <div class="row">
        <div v-for="Widget in Widgets" class="col-12 col-md-6 col-lg-4">
          <router-link :to="'/admin/widgets/'+ Widget.id">
            <div class="d-flex p-2">
              <div style="width:40px;">
                <i v-if="Widget.type === 'IMAGE'" class="far fa-image"></i>
                <i v-else class="fas fa-font"></i>
              </div>
              <div class="align-self-center">
                {{ Widget.name }}
              </div>
            </div>
          </router-link>
        </div>
      </div>



      </div>
    </div>

    <div class="mt-3 justify-content-center d-flex text-center">
      <b-pagination size="md" :total-rows="totalRows" v-model="Page" :per-page="perPage" @input="getItems(Page)">
      </b-pagination>
    </div>

  </div>

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
        Widgets: null,
        Page:1,
        perPage: 50,
        totalRows:100,
      }
    },
    mounted() {
      this.getItems();
    },
    methods: {
      getItems() {
        let self=this;
        self.Items={};
        self.$axios.get('/api/admin/widgets?page='+(parseInt(self.Page)-1)).then(function (res) {
          self.Widgets=res.data.results;
          self.totalRows=res.data.total;

        })
      }
    }
  }

</script>
