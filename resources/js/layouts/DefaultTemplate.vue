<template>
  <main>
    <DesktopNav />
    <MobileNav />
    <router-view></router-view>

  </main>
</template>

<script>

import DesktopNav from "./components/DesktopNav";
import MobileNav from "./components/MobileNav";

export default {
  components: {
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
