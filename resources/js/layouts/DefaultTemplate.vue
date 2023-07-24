<template>
  <main>
    <DesktopNav />
    <MobileNav />
    <div class="content">
      <router-view></router-view>
    </div>
    <PageFooter />


  </main>
</template>

<script>

import DesktopNav from "./components/DesktopNav";
import MobileNav from "./components/MobileNav";
import PageFooter from "./components/Footer.vue";

export default {
  components: {
    PageFooter,
    DesktopNav,
    MobileNav
  },
  computed: {
    user() {
      return this.$store.getters.user
    }
  },
}
</script>
