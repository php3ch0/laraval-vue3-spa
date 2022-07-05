<template>
  <AdminTemplate>
    <template #content>
      <div class="flex mb-3">
        <div class="flex-auto self-center">
          <h1 class="text-2lg uppercase">Manage Users</h1>
        </div>
        <div class="flex-none justify-end self-center">
          <a @click="toggleAddUserModal" class="btn btn-secondary ml-2">Add User</a>
          <router-link to="/admin" class="btn btn-secondary ml-2">Go Back</router-link>
        </div>
      </div>
      <Card title="Manage Users">
        <loading v-if="loading" />
        <table v-else class="table highlight">
          <thead>
            <tr>
              <th>Name</th>
              <th>Access Level</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          <tr v-for="u in users">
            <td>
              <strong>{{ u.firstname }} {{ u.lastname }}</strong><br>
              <small>{{ u.email }}</small>
            </td>
            <td>
              {{ u.role }}
            </td>
            <td class="text-right">
              <router-link :to="'/admin/users/'+u.id" class="btn">View</router-link>
            </td>
          </tr>
          </tbody>
        </table>
      </Card>

      <Modal :show="addUserModal" @close="toggleAddUserModal" width="lg" title="Add User">
        <template #body>
         <Loading v-if="loading" />
         <form v-else @submit.prevent="addUserSubmit">
           <div class="grid grid-cols-2 gap-4">
             <div>
               <div class="mb-2">
                 <label>First Name</label>
                 <input type="text" v-model="addUser.firstname" :class="{'error':(addUserErrors.firstname)}" />
                 <div class="form-error" v-if="addUserErrors.firstname">{{ addUserErrors.firstname[0] }}</div>
               </div>
               <div class="mb-2">
                 <label>Last Name</label>
                 <input type="text" v-model="addUser.lastname" :class="{'error':addUserErrors.lastname}" />
                 <div class="form-error" v-if="addUserErrors.lastname">{{ addUserErrors.lastname[0] }}</div>
               </div>
               <div class="mb-2">
                 <label>Last Name</label>
                 <input type="email" v-model="addUser.email" :class="{'error':addUserErrors.email}" />
                 <div class="form-error" v-if="addUserErrors.email">{{ addUserErrors.email[0] }}</div>
               </div>
             </div>
             <div>
               <div class="mb-2">
                 <label>Access Level</label>
                 <select v-model="addUser.role" :class="{'error':addUserErrors.role}">
                   <option value="user">User</option>
                   <option value="admin">Admin</option>
                 </select>
                 <div class="form-error" v-if="addUserErrors.role">{{ addUserErrors.role[0] }}</div>
               </div>

               <div class="mb-2">
                 <label>Password</label>
                 <input type="password" autocomplete="new-password" v-model="addUser.password" :class="{'error':(addUserErrors.password)}" />
                 <div class="form-error" v-if="addUserErrors.password">{{ addUserErrors.password[0] }}</div>
               </div>

               <div class="mb-2">
                 <label>Confirm Password</label>
                 <input type="password" autocomplete="new-password" v-model="addUser.password_confirmation" :class="{'error':addUserErrors.password_confirmation}" />
                 <div class="form-error" v-if="addUserErrors.password_confirmation">{{ addUserErrors.password_confirmation[0] }}</div>
               </div>

             </div>
           </div>
           <hr>
           <div class="text-center p-3">
             <button type="submit" class="btn btn-primary">Add User</button>
           </div>
         </form>
        </template>
      </Modal>


    </template>
  </AdminTemplate>

</template>

<script>




export default {
  name: "AdminUsersIndex",

  data() {
    return {
      loading:false,
      users:{},
      addUserModal:false,
      addUser: {
        firstname:'',
        lastname:'',
        password:'',
        password_confirmation:'',
        role:'user'
      },
      addUserErrors:{}

    }
  },

  mounted() {
    let self=this;
    this.getUsers();
  },

  methods: {
    getUsers() {
      let self=this;
      self.loading=true;
      axios.get('/api/users').then(function(res) {
        self.users = res.data;
        self.loading = false;
      })
    },
    toggleAddUserModal() {
      let self=this;
      self.addUserModal = !self.addUserModal;
    },
    addUserSubmit() {
      let self=this;
      self.loading=true;
      axios.post('/api/users',self.addUser).then(function(res) {
        self.loading=false;
        self.addUserModal=false;
        self.getUsers();
      }).catch(e=> {
        self.loading=false;
        console.log(e.response.data.message);
        self.addUserErrors=e.response.data.errors;

      })
    }
  }

}
</script>
