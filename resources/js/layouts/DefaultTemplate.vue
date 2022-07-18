<template>
  <main>
    <Topbar />
    <navigation></navigation>
    <router-view></router-view>
    <PageFooter />

  </main>
</template>

<script>
import Navigation from './components/Navigation'
import Topbar from "./components/Topbar";
import PageFooter from "./components/Footer";

export default {
  components: {
    PageFooter,
    Topbar,
    Navigation,
  },
  computed: {
    user() {
      return this.$store.getters.user
    }
  },
}
</script>
