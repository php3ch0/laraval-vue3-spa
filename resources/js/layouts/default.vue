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
import Header from "./components/Header";
import Footer from "./components/Footer";
import Navbar from "./components/Navbar";

export default {
  name: 'DefaultLayout',

  components: {
    NotificationHeader,
    Header,Footer,Navbar
  }
}
</script>
