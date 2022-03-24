<template>
    <header id="HeaderDesktop" class="d-none d-md-block">
      <div class="container p-3">
        <div class="row">
          <div class="col-12 text-center text-lg-start col-lg-auto align-self-center">
            <router-link to="/">
              <h2>Logo</h2>
            </router-link>
          </div>
          <div class="col-12 col-lg-auto ms-lg-auto align-self-center text-center text-lg-end">
              <div class="contacts">
                <div class="contact-row">T: <a href="tel:0000">0000</a></div>
                <div class="contact-row">E: <a href="mailto:info@website.co.uk">info@website.co.uk</a></div>
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
