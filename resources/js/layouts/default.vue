<template>
  <div class="main-layout">
    <NotificationHeader align="left" />
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
import NotificationHeader from "./components/NotificationHeader";
import Navbar from "./components/Navbar";

export default {
  name: 'MainLayout',

  components: {
    NotificationHeader,
    Header,Footer,Navbar
  }
}
</script>
