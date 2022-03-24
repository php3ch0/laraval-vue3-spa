<template>
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
        <span class="navbar-toggler-icon" />
      </button>

      <div id="navbar" class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">

          <li><router-link to="/">Home</router-link></li>
          <li><router-link to="/about">About</router-link></li>
          <li><router-link to="/services">Services</router-link></li>
          <li><router-link to="/galleries">Gallery</router-link></li>
          <li><router-link to="/blog">News</router-link></li>
          <li><router-link to="/contact">Contact</router-link></li>
          <li class="nav-item dropdown" v-if="user">
            <a class="nav-link dropdown-toggle"
               href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            >
              {{ user.firstname }}
            </a>
            <div class="dropdown-menu">
              <router-link to="/account/profile" class="dropdown-item ps-3">
                <i class="far fa-address-card fa-fw me-2"></i>
                Update Profile
              </router-link>
              <router-link to="/account/password" class="dropdown-item ps-3">
                <i class="fas fa-key fa-fw me-2"></i>
                Change Password
              </router-link>
              <router-link v-if="user.role==='admin'" to="/admin" class="dropdown-item ps-3">
                <i class="fas fa-cogs fa-fw me-2"></i>
                Administrator
              </router-link>

              <div class="dropdown-divider" />
              <a href="#" class="dropdown-item ps-3" @click.prevent="logout">
                <i class="fas fa-sign-out-alt fa-fw me-2"></i>
                Logout
              </a>
            </div>
          </li>


        </ul>


      </div>
    </div>
  </nav>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name:'NavBar',


  data: () => ({
    appName: window.config.appName
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to home page
      this.$router.push('/')
    }
  }
}
</script>
