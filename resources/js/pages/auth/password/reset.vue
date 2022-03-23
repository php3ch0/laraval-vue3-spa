<template>
  <div id="ResetPasswordPage">

    <div class="container align-self-center pt-3 pb-3">
        <div class="row">
    <div class="col-lg-7 m-auto">
      <card title="Reset Your Password">
        <form @submit.prevent="reset">


         <loadingsm v-if="loading" />

          <template v-else>

            <div v-if="success" class="alert alert-success mb-2">
              Your password has been successfully reset. You will shortly be forwarded to the login page.
            </div>


            <div class="mb-2">
              <label>Email Address</label>
              <input v-model="form.email" type="text" placeholder="Email" :class="{'error': errors.email }" class="form-control" pattern="\S+.*" required disabled />
              <div v-if="errors.email" class="form-error">{{ errors.email[0]}}</div>
            </div>
            <div class="mb-2">
              <label>New Password</label>
              <input v-model="form.password" type="password" placeholder="New Password" :class="{'error': errors.password }" class="form-control" pattern="\S+.*" required />
              <div v-if="errors.password" class="form-error">{{ errors.password[0]}}</div>
            </div>
            <div class="mb-2">
              <label>Confirm Password</label>
              <input v-model="form.password_confirmation" type="password" placeholder="Confirm Password" :class="{'error': errors.password_confirmation }" class="form-control" pattern="\S+.*" required />
              <div v-if="errors.password_confirmation" class="form-error">{{ errors.password_confirmation[0]}}</div>
            </div>


            <div class="mb-2">
              <button type="submit" class="btn btn-primary">Reset Password</button>
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

import LoadingSm from "../../../components/LoadingSm";

export default {
  layout:'plain',
  components: {LoadingSm},
  middleware: 'guest',

  metaInfo () {
    return { title: 'Reset Your Password | '+window.config.appName }
  },

  data: () => ({
    loading:false,
    success:false,
    form:{},
    errors:{}
  }),

  created () {
    this.form.email = this.$route.query.email
    this.form.token = this.$route.params.token
  },

  methods: {
    reset () {
      let self=this;
      self.loading=true;
      self.$axios.post('/api/password/reset',self.form).then(function(res) {
        self.success=true;
        self.loading=false;
        setTimeout(function() {
          self.$router.push('/login');
        },2000);

      }).catch(e=> {
        self.loading=false;
        self.errors=e.response.data.errors;
      })
    }
  }
}
</script>
