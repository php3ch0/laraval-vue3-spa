<template>
  <div id="RegisterPage">

    <div class="container align-self-center pt-3 pb-3">
      <div  class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">

        <card title="Create An Account">
          <form @submit.prevent="register">

            <LoadingSm v-if="loading" />

            <template v-else>

              <div v-if="success" class="alert alert-success mb-3">Your account has been created</div>

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
                  <div class="mb-2">
                    <label>Password</label>
                    <input v-model="user.password"  type="password" placeholder="Password" :class="{'error': errors.password }" class="form-control" pattern="\S+.*" required />
                    <div v-if="errors.password" class="form-error">{{ errors.password[0]}}</div>
                  </div>
                  <div class="mb-2">
                    <label>Confirm Password</label>
                    <input v-model="user.password_confirmation" type="password" placeholder="Confirm Password" :class="{'error': errors.password_confirmation }" class="form-control" pattern="\S+.*" required />
                    <div v-if="errors.password_confirmation" class="form-error">{{ errors.password_confirmation[0]}}</div>
                  </div>
                </div>
                <div class="col-12 col-md-6">
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
                  <div class="mb-2 mt-1">
                    <label>Telephone</label>
                    <input v-model="user.telephone" type="text" placeholder="Telephone" :class="{'error': errors.telephone }" class="form-control" pattern="\S+.*" required />
                    <div v-if="errors.telephone" class="form-error">{{ errors.telephone[0]}}</div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="text-center">
                <button type="submit" class="btn btn-lg btn-primary">Create Account</button>
              </div>

            </template>



          </form>
        </card>



      </div>
      </div>
    </div>
  </div>
</template>

<script>

import LoadingSm from "../../components/LoadingSm";
export default {
  components: {
    LoadingSm

  },
  layout:'default',

  metaInfo () {
    return { title: 'Create Account | '+window.config.appName }
  },

  data: () => ({
    user:{
      country_id:226
    },
    errors:{},
    loading:false,
    success:false,
    countries:{}
  }),

  mounted() {
    this.getCountries();
  },

  methods: {
    getCountries() {
      let self=this;
      self.countries={};
      self.$axios.get('/api/countries').then(function (res) {
        self.countries = res.data;
      });
    },
    register () {
      let self=this;
      self.loading=true;

      // Register the user.
      self.$axios.post('/api/register', self.user).then(function (res) {

        self.$axios.post('/api/login',{ 'email':self.user.email, 'password':self.user.password }).then(function(res) {

          self.$store.dispatch('auth/saveToken', {
            token: res.data.token,
          });
          // Fetch the user.
          self.$store.dispatch('auth/fetchUser')
          // Redirect home.
          if(self.$route.params.nextUrl && self.$route.params.nextUrl !=='/login') {
            self.$router.push(self.$route.params.nextUrl)
          } else {
            self.$router.push('/account')
          }

        });

      }).catch((error) => {
        self.loading=false;
        self.errors = error.response.data;
      });

    }
  }
}
</script>
