<template>

  <div id="AdminMenu">
    <div class="white-box">
      <ul>
        <li><router-link to="/admin">Dashboard</router-link></li>
        <li><router-link to="/admin/users">Users</router-link></li>
        <li><router-link to="/admin/blog">Blog</router-link></li>
        <li><router-link to="/admin/projects">Projects</router-link></li>
        <li><router-link to="/admin/opportunities">Opportunities</router-link></li>
        <li><router-link to="/admin/widgets">Widgets</router-link></li>
        <li><router-link to="/admin/galleries">Galleries</router-link></li>
        <li><router-link to="/admin/testimonials">Testimonials</router-link></li>
        <li><router-link to="/account">Return To Account</router-link></li>
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
