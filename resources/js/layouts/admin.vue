<template>
  <div id="admin-layout">

    <div>
      <b-navbar toggleable="lg" type="dark" class="header-top fixed-top ps-3 pe-3 d-print-none">
        <b-navbar-brand to="/admin">Administration Portal</b-navbar-brand>

          <b-navbar-nav class="ms-md-auto d-md-flex">
            <a href="/">Exit To Web Site</a>
          </b-navbar-nav>

      </b-navbar>

      <div>
        <div class="row p-0">
          <div class="col-auto d-print-none" style="width:200px;">
            <b-navbar-nav class="animate side-nav">
              <b-nav-item to="/admin" class="nav-header">Dashboard</b-nav-item>
              <b-nav-item to="/admin/users" class="nav-header">Users</b-nav-item>





              <div class="accordion">
                <a href="#" class="nav-header" @click.prevent="" v-b-toggle.content-nav>Page Content</a>
                <b-collapse id="content-nav" role="tabpanel" accordion="nav-accordion">
                  <b-nav-item to="/admin/blog">Blog</b-nav-item>
                  <b-nav-item to="/admin/services">Services</b-nav-item>
                  <b-nav-item to="/admin/testimonials">Testimonials</b-nav-item>
                  <b-nav-item to="/admin/galleries">Galleries</b-nav-item>
                  <b-nav-item to="/admin/widgets">Widgets</b-nav-item>
                </b-collapse>
              </div>







            </b-navbar-nav>
          </div>
          <div class="col">
            <div class="p-3">
              <child :key="$route.fullPath" />
            </div>

          </div>
        </div>

      </div>
    </div>




  </div>
</template>

<script>

  import { mapGetters } from 'vuex';

export default {
  name: 'MainLayout',
  middleware:'admin',
  components: {

  },
  computed: mapGetters({
    user: 'auth/user'
  }),
  methods: {

    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout');
      // Redirect to login.
      this.$router.push('/login')
    },
  }
}
</script>
