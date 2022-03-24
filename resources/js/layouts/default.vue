<template>
  <div class="main-layout">
    <HeaderDesktop  />
    <headerMobile />


    <div class="content">
      <child />
    </div>


    <Footer />

  </div>
</template>

<script>
import { mapGetters } from 'vuex';

import HeaderMobile from "./components/HeaderMobile";
import Footer from "./components/Footer";
import HeaderDesktop from "./components/HeaderDesktop";

export default {
  name: 'DefaultLayout',

  components: {
    HeaderDesktop,HeaderMobile,Footer
  },
  computed: mapGetters({
    user: 'auth/user',
  }),
}
</script>
