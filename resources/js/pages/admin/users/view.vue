<template>
  <div id="AdminUsersEdit">

      <div class="flex mb-3">
        <div class="flex-auto self-center">
          <h1 class="text-2lg ">Manage User</h1>
        </div>
        <div class="flex-none justify-end self-center">
          <router-link to="/admin/users" class="btn btn-secondary ml-2">Go Back</router-link>
        </div>
      </div>
      <Card title="Manage Users">
        <loading v-if="loading" />
        <form v-else @submit.prevent="editUserSubmit">

          <Transition name="alert">
            <div v-if="success" class="mt-3 mb-3 alert alert-success">Changes saved....</div>
          </Transition>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <div class="mb-2">
                <label>First Name</label>
                <input type="text" v-model="editUser.firstname" :class="{'error':(editUserErrors.firstname)}" />
                <div class="form-error" v-if="editUserErrors.firstname">{{ editUserErrors.firstname[0] }}</div>
              </div>
              <div class="mb-2">
                <label>Last Name</label>
                <input type="text" v-model="editUser.lastname" :class="{'error':editUserErrors.lastname}" />
                <div class="form-error" v-if="editUserErrors.lastname">{{ editUserErrors.lastname[0] }}</div>
              </div>
              <div class="mb-2">
                <label>Email</label>
                <input type="email" v-model="editUser.email" :class="{'error':editUserErrors.email}" />
                <div class="form-error" v-if="editUserErrors.email">{{ editUserErrors.email[0] }}</div>
              </div>
              <div class="mb-2">
                <label>Telephone</label>
                <input type="text" v-model="editUser.telephone" :class="{'error':editUserErrors.telephone}" />
                <div class="form-error" v-if="editUserErrors.telephone">{{ editUserErrors.telephone[0] }}</div>
              </div>

              <div class="form-group mb-2">
                <label>Date Of Birth</label>
                <div class="flex gap-4">
                  <div>
                    <input v-model="editUser.day" class="form-control" type="number" min="1" max="31" />
                  </div>
                  <div>
                    <select v-model="editUser.month" class="form-control">
                      <option value="1">Jan</option>
                      <option value="2">Feb</option>
                      <option value="3">Mar</option>
                      <option value="4">Apr</option>
                      <option value="5">May</option>
                      <option value="6">Jun</option>
                      <option value="7">Jul</option>
                      <option value="8">Aug</option>
                      <option value="9">Sep</option>
                      <option value="10">Oct</option>
                      <option value="11">Nov</option>
                      <option value="12">Dec</option>
                    </select>
                  </div>
                  <div>
                    <input v-model="editUser.year" class="form-control" type="number" min="1940" :max="new Date().getFullYear()" />
                  </div>

                </div>

                <div v-if="editUserErrors && editUserErrors.dob" class="form-error">{{ editUserErrors.dob[0]}}</div>
              </div>
              <div class="form-group mb-2">
                <label>Upload CV</label>
                <input  class="form-control" type="file" ref="file" @change="addFile" accept=".pdf,.doc,.docx" />
                <small>Word Document or PDF File. Max 12MB</small>
                <div v-if="editUserErrors && editUserErrors.cvfile" class="form-error">{{ editUserErrors.cvfile[0]}}</div>
              </div>
            </div>
            <div>
              <div class="form-group mb-2">
                <label>Key Skills</label>
                <textarea v-model="editUser.skills" class="form-control" style="height:90px">
                        </textarea>
                <small>e.g Lighting, Production, VFX, Camera, Post Production</small>
                <div v-if="editUserErrors && editUserErrors.skills" class="form-error">{{ editUserErrors.skills[0]}}</div>
              </div>
              <div class="mb-2">
                <label>Access Level</label>
                <select v-model="editUser.role" :class="{'error':editUserErrors.role}">
                  <option value="user">User</option>
                  <option value="member">Member</option>
                  <option value="admin">Admin</option>
                </select>
                <div class="form-error" v-if="editUserErrors.role">{{ editUserErrors.role[0] }}</div>
              </div>

              <div class="mb-2">
                <label>Password</label>
                <input type="password" autocomplete="new-password" v-model="editUser.password" :class="{'error':(editUserErrors.password)}" />
                <div class="form-error" v-if="editUserErrors.password">{{ editUserErrors.password[0] }}</div>
              </div>

              <div class="mb-2">
                <label>Confirm Password</label>
                <input type="password" autocomplete="new-password" v-model="editUser.password_confirmation" :class="{'error':editUserErrors.password_confirmation}" />
                <div class="form-error" v-if="editUserErrors.password_confirmation">{{ editUserErrors.password_confirmation[0] }}</div>
              </div>

            </div>
          </div>
          <hr>
          <div class="text-center p-3">
            <a v-if="editUser.cvfile" :href="'/api/users/'+editUser.id+'/cv'" target="_blank" class="btn btn-secondary mx-2">Download CV</a>
            <button type="submit" class="btn btn-primary mx-2">Save Changes</button>
            <ConfirmButton text="Delete User" class="mx-2" @confirm="deleteUser" />

          </div>
        </form>


      </Card>

  </div>

</template>

<script>




import ConfirmButton from "../../../components/ConfirmButton";
export default {
  name: "AdminUsersView",
  components: {ConfirmButton},
  data() {
    return {
      loading:false,
      success:false,
      editUser: {
        firstname:'',
        lastname:'',
        password:'',
        password_confirmation:'',
        role:'user'
      },
      editUserErrors:{}

    }
  },

  mounted() {
    let self=this;
    self.getUser();
  },

  methods: {
    getUser() {
      let self=this;
      self.loading=true;
      axios.get('/api/users/'+self.$route.params.id).then(function(res) {
        self.editUser = res.data;
        self.loading = false;
      })
    },

    editUserSubmit() {
      let self=this;
      self.loading=true;
      self.success=false;
      self.editUserErrors={};
      axios.patch('/api/users/'+self.editUser.id,self.editUser).then(function(res) {
        self.loading=false;
        self.success=true;
        setTimeout(function() {
          self.success=false;
        },3000);
      }).catch(e=> {
        self.loading=false;
        console.log(e.response.editUser.message);
        self.editUserErrors=e.response.editUser.editUserErrors;

      })
    },
    deleteUser() {
      let self=this;
      axios.delete('/api/users/'+self.editUser.id).then(function(res) {
        self.$router.push('/admin/users');
      }).catch(e=> {
        console.log(e.response.data);
      })
    }
  }

}
</script>
