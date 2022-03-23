<template>
  <div id="AccountPage">
    <div class="container mt-3 mb-3">
      <card title="Welcome To Your Account">
        <router-link to="/account/profile">Update Profile</router-link><br>
        <router-link to="/account/password">Change Password</router-link><br>
        <router-link v-if="user.role==='admin'" to="/admin">Admin Dashboard</router-link><br>
        <a href="#" @click.prevent="logout">Log Out</a><br>
      </card>
    </div>

  </div>
</template>

<script>

import { mapGetters } from 'vuex';

export default {
  name: "account.index",
  middleware:'auth',

  computed: mapGetters({
    user: 'auth/user'
  }),
  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout');
      // Redirect to login.
      this.$router.push('/')
    },

  },
}
</script>
