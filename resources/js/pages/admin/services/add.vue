<template>

  <div id="AdminAddServices">
    <div class="row">
      <div class="col-9">
        <h1>Manage Services</h1>
      </div>
      <div class="col-3 text-end">
          <router-link to="/admin/services" class="btn btn-primary">Go Back</router-link>
      </div>
    </div>



    <div class="mt-3">
      <card title="Add A Service">
        <div v-if="ErrorMessages" class="alert alert-danger mb-3">
          <div v-for="Error in ErrorMessages">
            {{ Error[0] }}
          </div>
        </div>
        <div class="mb-2">
          <label>Please enter a name for this service.</label>
          <input v-model="Service.name" class="form-control" />
        </div>
        <div class="mb-2">
          <button class="btn btn-primary" @click="addService">Add Service</button>
        </div>
      </card>
    </div>

  </div>

</template>

<script>

    export default {
        name: "AdminAddServices",
        middleware: 'admin',
        layout:'admin',
        data () { return {
            ErrorMessages:null,
            Service:{
                name:null
            },
        }},

        methods: {
            addService() {
                let self=this;
                self.ErrorMessages=null;
                self.$axios.post('/api/services/add', self.Service).then(function (res) {
                    self.$router.push('/admin/services/'+res.data.id);
                }).catch((error) => {
                    self.ErrorMessages = error.response.data.errors;
            });
            }
        }

    }
</script>
