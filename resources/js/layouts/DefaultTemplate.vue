<template>
  <main>
    <navigation></navigation>
    <router-view></router-view>
  </main>
</template>

<script>
import Navigation from './components/Navigation'

export default {
  components: {
    Navigation,
  },
  computed: {
    user() {
      return this.$store.getters.user
    }
  },
}
</script>
