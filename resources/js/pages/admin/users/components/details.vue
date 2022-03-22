<template>

  <div id="UserDetails">
    <form @submit.prevent="updateUser" autocomplete="off">
      <input autocomplete="false" name="hidden" type="text" style="display:none;">

      <LoadingSm v-if="loading" />
      <template v-else>
        <div v-if="success" class="alert alert-success mb-2">User details have been updated</div>

        <div class="row">
          <div class="col-12 col-md-6">
            <div class="mb-2">
              <label>First Name</label>
              <input v-model="user.firstname" type="text" placeholder="First Name" :class="{'error': errors.firstname }" class="form-control" pattern="\S+.*" required />
              <div v-if="errors.firstname" class="form-error">{{ errors.firstname[0]}}</div>
            </div>
            <div class="mb-2">
              <label>Last Name</label>
              <input v-model="user.lastname" type="text" placeholder="Last Name" :class="{'error': errors.lastname }" class="form-control" pattern="\S+.*" required />
              <div v-if="errors.lastname" class="form-error">{{ errors.lastname[0]}}</div>
            </div>
            <div class="mb-2">
              <label>Email Address</label>
              <input v-model="user.email" type="email" placeholder="Email" :class="{'error': errors.email }" class="form-control" pattern="\S+.*" required />
              <div v-if="errors.email" class="form-error">{{ errors.email[0]}}</div>
            </div>
            <div class="mb-2 mt-1">
              <label>Telephone</label>
              <input v-model="user.telephone" type="text" placeholder="Telephone" :class="{'error': errors.telephone }" class="form-control" pattern="\S+.*" />
              <div v-if="errors.telephone" class="form-error">{{ errors.telephone[0]}}</div>
            </div>
            <div class="mb-2 mt-1">
              <label>Mobile</label>
              <input v-model="user.mobile" type="text" placeholder="Mobile" :class="{'error': errors.mobile }" class="form-control" pattern="\S+.*" />
              <div v-if="errors.mobile" class="form-error">{{ errors.mobile[0]}}</div>
            </div>

            <div class="mb-2">
              <label>Password (leave blank to keep same)</label>
              <input v-model="user.password"  type="password" placeholder="Password" :class="{'error': errors.password }" class="form-control"  />
              <div v-if="errors.password" class="form-error">{{ errors.password[0]}}</div>
            </div>
            <div class="mb-2">
              <label>Confirm Password</label>
              <input v-model="user.password_confirmation" type="password" placeholder="Confirm Password" :class="{'error': errors.password_confirmation }" class="form-control"  />
              <div v-if="errors.password_confirmation" class="form-error">{{ errors.password_confirmation[0]}}</div>
            </div>

          </div>
          <div class="col-12 col-md-6">
            <div class="mb-2">
              <label>Access Level</label>
              <select v-model="user.role" type="text" placeholder="Access Level" :class="{'error': errors.role }" class="form-control" pattern="\S+.*" required>
                <option :value="null">None</option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
              </select>
              <div v-if="errors.password_confirmation" class="form-error">{{ errors.password_confirmation[0]}}</div>
            </div>
            <div class="mb-2">
              <label>Company Name</label>
              <input v-model="user.company_name" type="text" placeholder="Company Name" :class="{'error': errors.company_name}" class="form-control" pattern="\S+.*" required />
              <div v-if="errors.company_name" class="form-error">{{ errors.company_name[0]}}</div>
            </div>
            <div class="mb-2">
              <label>Address</label>
              <input v-model="user.address1" type="text" placeholder="Address 1" :class="{'error': errors.address1 }" class="form-control" pattern="\S+.*" required />
              <div v-if="errors.address1" class="form-error">{{ errors.address1[0]}}</div>
            </div>
            <div class="mb-2">
              <input v-model="user.address2" type="text" placeholder="Address 2" :class="{'error': errors.address2 }" class="form-control"  />
              <div v-if="errors.address2" class="form-error">{{ errors.address2[0]}}</div>
            </div>
            <div class="mb-2">
              <input v-model="user.town" type="text" placeholder="Town" :class="{'error': errors.town }" class="form-control" pattern="\S+.*" required />
              <div v-if="errors.town" class="form-error">{{ errors.town[0]}}</div>
            </div>
            <div class="mb-2">
              <input v-model="user.postcode" type="text" placeholder="Postcode" :class="{'error': errors.postcode }" class="form-control" pattern="\S+.*" required />
              <div v-if="errors.postcode" class="form-error">{{ errors.postcode[0]}}</div>
            </div>
            <div class="mb-2">
              <label>Country</label>
              <select v-model="user.country_id"  placeholder="Country" :class="{'error': errors.country_id }" class="form-control" pattern="\S+.*" required>
                <option v-for="c in countries" :value="c.id">{{ c.name }}</option>
              </select>
              <div v-if="errors.country_id" class="form-error">{{ errors.country_id[0]}}</div>
            </div>

          </div>
        </div>
        <hr>
        <div class="text-center">
          <button type="submit" class="btn btn-lg btn-primary">Save Changes</button>
        </div>

      </template>

    </form>
  </div>

</template>

<script>
import LoadingSm from "../../../../components/LoadingSm";
export default {
  name: "UserDetails",
  components: {LoadingSm},
  middleware: 'admin',

  metaInfo () {
    return { title: 'Admin Portal | '+window.config.appName}
  },

  props: {
    id:Number
  },

  data: () => ({
    loading:false,
    user:{},
    success:false,
    errors:{},
    countries:{}
  }),

  mounted() {
    this.getUser();
    this.getCountries();
  },
  methods: {
    getUser() {
      let self=this;
      self.loading=true;
      self.$axios.get('/api/users/'+self.id).then(function(res) {
        self.loading=false;
        self.user = res.data;
      }).catch(e=>{
        self.loading=false;
        console.log(e.response.data);
      })
    },
    getCountries() {
      let self=this;
      self.countries={};
      self.$axios.get('/api/countries').then(function (res) {
        self.countries = res.data;
      });
    },
    updateUser() {
      let self=this;
      self.loading=true;
      self.errors={};
      self.success=false;
      self.$axios.post('/api/users/'+self.user.id,self.user).then(function(res) {
        self.loading=false;
        self.success=true;
        setTimeout(function() {
          self.success=false;
        },3000);
      }).catch(e=> {
        self.errors=e.response.data;
        self.loading=false;
      })
    }
  }
}
</script>
