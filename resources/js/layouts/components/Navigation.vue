<template>
  <nav id="TopNav" class="bg-white border-b border-gray-200 p-4">
    <div class="container mx-auto flex justify-center md:justify-between">
      <router-link :to="{name: 'Home'}" class="hidden md:flex text-xl font-semibold place-items-center space-x-2">
        <img src="/storage/images/logo.webp" class="h-[80px]" alt="Shepway Computer Support and Repair Folkestone, Kent" />
      </router-link>
      <ul class="list flex items-center">
        <li>
          <router-link :to="{name: 'Home'}">
            <span>Home</span>
          </router-link>
        </li>
        <li>
          <router-link to="/services/telephone">
            <span>Telephone IT Support</span>
          </router-link>
        </li>
        <li>
          <router-link to="/services/repairs">
            <span>Computer & Laptop Repairs</span>
          </router-link>
        </li>
        <li>
          <router-link to="/services/apple">
            <span>Apple Support</span>
          </router-link>
        </li>
        <li>
          <router-link to="/services/callouts">
            <span>Callouts</span>
          </router-link>
        </li>
        <li>
          <router-link to="/news">
            <span>News</span>
          </router-link>
        </li>
        <li>
          <router-link to="/sales">
            <span>Sales</span>
          </router-link>
        </li>
        <li>
          <router-link to="/contact">
            <span>Contact Us</span>
          </router-link>
        </li>

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
