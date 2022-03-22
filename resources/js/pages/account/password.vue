<template>
  <div id="profilePage">
    <div class="container align-self-center pt-3 pb-3">
      <div  class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">

        <card title="Change Password">
          <form @submit.prevent="update">

            <LoadingSm v-if="loading" />

            <template v-else>

              <div v-if="success" class="alert alert-success mb-3">Your password has been updated</div>


              <div class="mb-2">
                <label>New Password</label>
                <input v-model="user.password"  type="password" placeholder="Password" :class="{'error': errors.password }" class="form-control" pattern="\S+.*" required />
                <div v-if="errors.password" class="form-error">{{ errors.password[0]}}</div>
              </div>
              <div class="mb-2">
                <label>Confirm New Password</label>
                <input v-model="user.password_confirmation" type="password" placeholder="Confirm Password" :class="{'error': errors.password_confirmation }" class="form-control" pattern="\S+.*" required />
                <div v-if="errors.password_confirmation" class="form-error">{{ errors.password_confirmation[0]}}</div>
              </div>
              <hr>
              <div class="text-center">
                <button type="submit" class="btn btn-lg btn-primary">Change Password</button>
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

import { mapGetters } from 'vuex'

export default {

  name:"account.password",
  layout:'default',
  middleware: 'auth',

  metaInfo () {
    return { title: 'Change Password | '+window.config.appName }
  },

  data: () => ({
    errors:{},
    loading:false,
    success:false,
    countries:{}
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),


  methods: {

    update() {
      let self=this;
      self.loading=true;

      // Register the user.
      self.$axios.post('/api/password', self.user).then(function (res) {

        self.loading=false;
        self.success=true;
        self.$store.dispatch('auth/fetchUser')

      }).catch((error) => {
        self.loading=false;
        self.errors = error.response.data;
      });

    }
  }
}
</script>
