<template>
    <header id="HeaderDesktop" class="d-none d-md-block">
      <div class="container p-3">
        <div class="row">
          <div class="col-12 text-center text-lg-start col-lg-auto align-self-center">
            <router-link to="/">
              <img src="/storage/images/logo_black.png" class="logo" alt="Penshurst Planning - Town Planning and Development Consultants in Kent" />
            </router-link>
          </div>
          <div class="col-12 col-lg-auto align-self-center text-center text-lg-start">
            <div class="logo-text">
              <span class="large">Penshurst Planning</span><br>
              <span class="medium">Town Planning and Development Consultants</span>
            </div>
          </div>
          <div class="col-12 col-lg-auto ms-lg-auto align-self-center text-center text-lg-end">
              <div class="contacts">
                <div class="contact-row">T: <a href="tel:01634294751">01634 294751</a></div>
                <div class="contact-row">E: <a href="mailto:info@penshurstplanning.co.uk">info@penshurstplanning.co.uk</a></div>
              </div>
          </div>
        </div>
      </div>
      <Navbar />


    </header>
</template>

<script>

import Navbar from "./Navbar";

export default {
  name: "HeaderDesktop",
  components: { Navbar}
}
</script>
