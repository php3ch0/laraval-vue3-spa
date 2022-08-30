<template>

  <div id="AdminMenu">
    <div class="white-box">
      <ul>
        <li><router-link to="/admin">Dashboard</router-link></li>
        <li><router-link to="/admin/users">Manage Users</router-link></li>
        <li><router-link to="/admin/widgets">Manage Widgets</router-link></li>
        <li><router-link to="/admin/galleries">Manage Galleries</router-link></li>
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
