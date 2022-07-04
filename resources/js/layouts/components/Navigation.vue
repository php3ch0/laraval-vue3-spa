<template>
  <nav class="bg-white border-b border-gray-200 p-4 mb-4">
    <div class="container mx-auto flex justify-center md:justify-between">
      <router-link :to="{name: 'Home'}" class="hidden md:flex text-xl font-semibold place-items-center space-x-2">
        <span>G1098 Tailoring</span>
      </router-link>
      <ul class="list flex items-center text-gray-500 text-sm font-semibold">
        <li>
          <router-link :to="{name: 'Home'}" class="hover:text-gray-700 p-2 rounded flex items-center space-x-2">
            <span>Home</span>
          </router-link>
        </li>
        <li v-if="user">
          <router-link to="/account" class="hover:text-gray-700 p-2 rounded flex items-center space-x-2 font-semibold">
            <span>Account</span>
          </router-link>
        </li>
        <li v-if="user && user.role==='admin'">
          <router-link to="/admin" class="hover:text-gray-700 p-2 rounded flex items-center space-x-2 font-semibold">
            <span>Admin</span>
          </router-link>
        </li>
        <li v-if="user" >
          <button @click="logout" class="hover:text-gray-700 p-2 rounded flex items-center space-x-2">
            <span>logout</span>
          </button>
        </li>
        <li v-if="!user">
          <router-link to="/login" class="hover:text-gray-700 p-2 rounded flex items-center space-x-2 font-semibold">
            <span>Login</span>
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
