<template>
  <nav id="DesktopNav" class="p-4 hidden lg:block xl:block">
    <div class="container mx-auto flex justify-center md:justify-between">
      <router-link :to="{name: 'Home'}" class="hidden md:flex text-xl font-semibold place-items-center space-x-2">
        <img src="/storage/images/logo.png" class="h-[100px]" alt="Folkestone Invicta Youth Football Club" />
      </router-link>
      <ul class="list flex items-center">
        <li>
          <router-link :to="{name: 'Home'}">
            <span>Home</span>
          </router-link>
        </li>
        <li>
          <router-link to="/about">
            <span>About</span>
          </router-link>
        </li>
        <li>
          <router-link to="/teams">
            <span>Teams</span>
          </router-link>
        </li>
        <li>
          <router-link to="/club">
            <span>The Club</span>
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
