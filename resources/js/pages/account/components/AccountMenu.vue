<template>

  <div id="AccountMenu">
    <div class="white-box">
      <ul>
        <li><router-link to="/account">Dashboard</router-link></li>
        <li><router-link to="/account/profile">Update Profile</router-link></li>
        <li><router-link to="/account/password">Change Password</router-link></li>
        <li><router-link to="/account/2fa">Two Factor Auth</router-link></li>
        <li v-if="user.role==='admin'"><router-link to="/admin">Admin</router-link></li>
        <li><a href="#" @click.prevent="logout">Logout</a></li>
      </ul>
    </div>
  </div>

</template>

<script>
export default {
  name: "AccountMenu",

  computed: {
    user() {
      return this.$store.getters.user
    },
  },
  methods: {
    logout() {
      let self = this;
      self.$store.dispatch('logout').then(function () {
        self.$router.push('/');
      })
    }
  }
}
</script>
