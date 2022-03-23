<template>
  <div class="main-layout">
    <Header  />
    <Navbar />

    <div class="content">
      <child />
    </div>


    <Footer />

  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import Header from "./components/Header";
import Footer from "./components/Footer";
import Navbar from "./components/Navbar";

export default {
  name: 'DefaultLayout',

  components: {
    Header,Footer,Navbar
  },
  computed: mapGetters({
    user: 'auth/user',
  }),
}
</script>
