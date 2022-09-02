<template>
  <nav id="DesktopNav" class="p-4 hidden lg:block xl:block">
    <div class="container mx-auto flex justify-center md:justify-between">
      <router-link :to="{name: 'Home'}" class="hidden md:flex text-xl font-semibold place-items-center space-x-2">
        <img src="/storage/images/logo.png" class="logo" alt="Shepway Computers - IT Support, Computer, Laptop and Apple Repairs in Folkestone, Kent" />
      </router-link>
      <ul class="list flex items-center">
        <li><router-link to="/" class="">Home</router-link></li>
        <li><router-link to="/services/telephone">Telephone IT Support</router-link></li>
        <li><router-link to="/services/repairs" class="">Computer &amp; Laptop Repairs</router-link></li>
        <li><router-link to="/services/apple" class="">Apple Support</router-link></li>
        <li><router-link to="/services/callouts" class="">Callouts</router-link></li>
        <li><router-link to="/news" class="">News</router-link></li>
        <li><router-link to="/sales" class="">Sales</router-link></li>
        <li><router-link to="/contact" class="">Contact Us</router-link></li>
      </ul>
    </div>
  </nav>
</template>

<script>
export default {
  computed: {
    user() {
      return this.$store.getters.user
    }
  },
  methods: {
    logout() {
      this.$store.dispatch('logout')
        .then(() => {
          this.$router.push({name: 'Login'})
        })
    }
  }
}
</script>
