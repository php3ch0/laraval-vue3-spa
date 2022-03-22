<template>
  <div class="main-layout">
    <NotificationHeader align="center" />

    <header class="container text-center">
      <router-link to="/">
        <img src="/storage/images/logo.svg" class="logo" alt="Print Junction Trade System" />
      </router-link>
    </header>

    <child />

    <div class="text-center footer2">
      <div id="logo">
        <img src="/storage/images/logo.svg" class="logo" alt="Print Junction Trade System" />
        <div class="contact"><a href="tel:01233624462"><i class="fas fa-phone"></i> 01233 624462</a></div>
        <div class="contact"><a href="mailto:trade@print-junction.co.uk"><i class="fas fa-at"></i> trade@print-junction.co.uk</a></div>
        <div class="footer2-links">
          <router-link to="/terms/privacy">Privacy Policy</router-link> | <router-link to="/terms/terms">Terms & Conditions</router-link> | Copyright Print Junction Limited 2021
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import NotificationHeader from "./components/NotificationHeader";


export default {
  name: 'MainLayout',

  components: {
    NotificationHeader,
  }
}
</script>
