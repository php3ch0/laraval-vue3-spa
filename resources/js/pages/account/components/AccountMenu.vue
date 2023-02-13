<template>

  <div id="AccountMenu">
    <div class="white-box hidden lg:block desktop">
      <ul>
        <li><router-link to="/account">Dashboard</router-link></li>
        <li><router-link to="/account/profile">Update Profile</router-link></li>
        <li><router-link to="/account/password">Change Password</router-link></li>
        <li><router-link to="/account/2fa">Two Factor Auth</router-link></li>
        <li v-if="user.role==='admin'"><router-link to="/admin">Admin</router-link></li>
        <li><a href="#" @click.prevent="logout">Logout</a></li>
      </ul>
    </div>
    <div class="block lg:hidden mobile">
      <div @click="openMenu" class="menu-title">Account Menu</div>
      <div class="menu-items" :class="{ 'nav-open': navOpen }">
        <ul>
          <li @click="closeMenu"><router-link to="/account">Dashboard</router-link></li>
          <li @click="closeMenu"><router-link to="/account/profile">Update Profile</router-link></li>
          <li @click="closeMenu"><router-link to="/account/password">Change Password</router-link></li>
          <li @click="closeMenu"><router-link to="/account/2fa">Two Factor Auth</router-link></li>
          <li @click="closeMenu" v-if="user.role==='admin'"><router-link to="/admin">Admin</router-link></li>
          <li @click="closeMenu"><a href="#" @click.prevent="logout">Logout</a></li>
        </ul>
      </div>
    </div>
  </div>

</template>

<script>
export default {
  name: "AccountMenu",

  data: () => ({
    navOpen:false,
  }),

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
      },
      openMenu() {
        let self=this;
        self.navOpen = !self.navOpen;
      },
      closeMenu() {
        let self=this;
        self.navOpen = false;
      }
    }
}
</script>
