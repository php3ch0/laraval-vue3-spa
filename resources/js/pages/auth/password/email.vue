<template>
  <div id="SendPasswordPage">

    <div class="container align-self-center pt-3 pb-3">
      <div class="row justify-content-center">
        <div class="col-lg-7 m-auto">
          <card title="Reset Password">
            <form @submit.prevent="send">

              <loadingsm v-if="loading" />

              <template v-else>

                <div v-if="success" class="alert alert-success mb-2">
                  Please check your email for your reset email.
                </div>

                <p v-else>Please enter your email address below and we will send you a password reset email link.</p>

                <div class="mb-2">
                  <label>Enter Email Address</label>
                  <input v-model="email" type="email" placeholder="Email Address" :class="{'error': errors.email }" class="form-control" pattern="\S+.*" required />
                  <div v-if="errors.email" class="form-error">{{ errors.email[0]}}</div>
                </div>

                <div class="mb-2">
                  <button type="submit" class="btn btn-primary">Send Password Reset Email</button>
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


export default {
  layout:'default',

  metaInfo () {
    return { title: "Reset Password | "+window.config.appName }
  },

  data: () => ({
    email:null,
    errors:{},
    success:false,
    loading:false
  }),

  methods: {
    send () {
      let self=this;
      self.errors={};
      self.success=false;
      self.loading=true;
      self.$axios.post('/api/password/email',{email:self.email}).then(function(res) {
        self.success=true;
        self.loading=false;
      }).catch(e=>{
        self.errors=e.response.data.errors;
        self.loading=false;
      })
    }
  }
}
</script>
