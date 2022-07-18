<template>

  <div id="AdminMenu">
    <div class="white-box">
      <ul>
        <li><router-link to="/admin">Dashboard</router-link></li>
        <li><router-link to="/admin/users">Manage Users</router-link></li>
        <li><router-link to="/admin/blog">Mange Blog</router-link></li>
        <li><router-link to="/admin/sales">Manage Products</router-link></li>
        <li><a href="/">Return To Web Site</a></li>
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

  }
}
</script>
