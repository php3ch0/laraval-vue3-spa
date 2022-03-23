<template>
  <div class="main-layout">

    <header class="container text-center">
      <router-link to="/">
        Logo
      </router-link>
    </header>

    <child />

    <div class="text-center footer2">

    </div>

  </div>
</template>

<script>

import { mapGetters } from 'vuex';

export default {
  name: 'PlainLayout',

  computed: mapGetters({
    user: 'auth/user',
  }),

}
</script>
