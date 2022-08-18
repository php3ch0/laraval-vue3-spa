<template>
  <main>
    <Topbar />
    <DesktopNav />
    <MobileNav />
    <router-view></router-view>
    <PageFooter />

  </main>
</template>

<script>
import Topbar from "./components/Topbar";
import PageFooter from "./components/Footer";
import DesktopNav from "./components/DesktopNav";
import MobileNav from "./components/MobileNav";

export default {
  components: {
    PageFooter,
    Topbar,
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
