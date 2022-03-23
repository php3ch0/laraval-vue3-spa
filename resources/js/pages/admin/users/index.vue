<template>
  <div id="AdminUsers">
    <div class="container pt-3 pb-3">

          <div class="row mb-2">
            <div class="col-auto">
              <h3>Manage Users</h3>
            </div>
            <div class="col-auto ms-auto justify-content-center">
              <form @submit.prevent="getUsers" class="row">
                <div class="col">
                  <input v-model="searchTerm" type="text" placeholder="Search For..." class="form-control" />
                </div>
                <div class="col-auto">
                  <button type="submit" class="btn btn-primary">Search</button>
                </div>
              </form>
            </div>
            <div class="col-auto">
              <router-link to="/admin/users/add" class="btn btn-primary">Add User</router-link>
            </div>
            <div class="col-auto">
              <router-link to="/admin" class="btn btn-primary">Go Back</router-link>
            </div>
          </div>

          <card title="Manage Users">

            <LoadingSm v-if="loading" />

            <template v-else>
              <table class="table">
                <thead>
                <tr>
                  <th>User Details</th>
                  <th>Email</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="u in users">
                  <td><strong>{{ u.lastname }}</strong>, {{ u.firstname }}</td>
                  <td>{{ u.email }}</td>
                  <td class="text-end"><router-link :to="'/admin/users/'+u.id" class="btn btn-primary">Edit</router-link></td>
                </tr>
                </tbody>
              </table>
            </template>





          </card>

        <div class="mt-3 justify-content-center d-flex text-center">
          <b-pagination size="md" :total-rows="totalRows" v-model="currentPage" :per-page="perPage" @input="getUsers(currentPage)" />
        </div>

    </div>
  </div>
</template>

<script>


export default {
  name:"admin.users.index",
  middleware: 'admin',
  layout:'admin',

  metaInfo () {
    return { title: 'Admin Portal | '+window.config.appName}
  },

  data: () => ({
    loading:false,
    users:{},
    totalRows:200,
    currentPage:1,
    perPage:25,
    searchTerm:null,

  }),

  mounted() {
    this.getUsers();
  },
  methods: {
    getUsers() {
      let self=this;
      self.loading=true;
      self.$axios.get('/api/users?term='+self.searchTerm+'&page='+self.currentPage).then(function(res) {
        self.users = res.data.results;
        self.totalRows=res.data.total;
        self.loading=false;
      }).catch(e=>{
        console.log(e.response.data);
      })
    }
  }
}
</script>
