<template>
  <div id="LoginPage">

    <div class="d-flex">
      <div class="container align-self-center pt-3 pb-3">
        <div class="row justify-content-center">
          <div class="col-12 col-md-10 col-lg-8 col-xl-7">

            <card title="Please Sign In">

              <template v-if="loading">
                <LoadingSm />
              </template>

              <template v-else>
                <div class="login-box p-2">

                  <form  @submit.prevent="login">
                    <div class="mb-3">
                      <label for="email" :class="{ error: errorsLogin.email }">Email Address</label>
                      <input v-model="formLogin.email"  class="form-control" type="text" name="email">
                      <div v-if="errorsLogin.email" class="form-error">{{ errorsLogin.email[0] }}</div>
                    </div>
                    <div class="mb-3">
                      <label for="password" :class="{ error: errorsLogin.password }">Password</label>
                      <input v-model="formLogin.password"  class="form-control" type="password" name="password">
                      <div v-if="errorsLogin.password" class="form-error">{{ errorsLogin.password[0] }}</div>
                    </div>
                    <div class="container-fluid p-0">
                      <div class="row">
                        <div class="col-12 col-xl-6 text-center text-xl-start align-self-center">
                          <button type="submit" class="btn btn-primary">Sign In</button>
                          <router-link to="/register" class="btn btn-secondary">Sign-Up</router-link>

                        </div>
                        <div class="col-12 col-xl-6 text-center text-xl-end align-self-center">
                          <router-link to="/password/reset" class="small">
                            Forgotten Your Password?
                          </router-link>
                        </div>
                      </div>
                    </div>


                  </form>

                </div>

              </template>


            </card>




          </div>


        </div>

      </div>
    </div>

  </div>
</template>

<script>


export default {

  layout:'plain',
  middleware: 'guest',

  metaInfo () {
    return { title: "Login | "+window.config.appName }
  },



  data: () => ({
    loading:false,
    errorsLogin:{},

    formLogin: {},

  }),

  mounted() {
    this.$store.dispatch('auth/logout')
  },

  methods: {
    login () {
      let self=this;
      self.loading=true;
      self.errorsLogin={};
      // Submit the form.
      self.$axios.post('/api/login',{ 'email':self.formLogin.email, 'password':self.formLogin.password }).then(function(res) {

        self.$store.dispatch('auth/saveToken', {
          token: res.data.token,
        });
        // Fetch the user.
        self.$store.dispatch('auth/fetchUser')
        // Redirect home.

        if(self.$route.params.nextUrl && self.$route.params.nextUrl !=='/login') {
          self.$router.push(self.$route.params.nextUrl)
        } else {
          self.$router.push('/')
        }
      }).catch(error => {
        self.loading=false;
        self.errorsLogin = error.response.data.errors;
      });

    },

  }
}
</script>
