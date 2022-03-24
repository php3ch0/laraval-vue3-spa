<template>
  <div id="HeaderMobile" class="d-md-none">
    <div class="container-fluid">
      <div class="row">
        <div class="col align-self-auto">
          <a href="/">
            <h2>Logo</h2>
          </a>
        </div>
        <div class="col-auto align-self-end align-self-center">

          <button class="hamburger hamburger--elastic p-0" :class="{ 'is-active': navOpen }" @click.prevent="toggleNav" type="button"
                  aria-label="Menu">
              <span class="hamburger-box">
                <span class="hamburger-inner"></span>
              </span>
          </button>
        </div>
      </div>
    </div>
    <div class="mobileNav" :class="{ 'nav-open': navOpen }">
      <ul class="navbar">
        <li @click="toggleNav"><router-link to="/">Home</router-link></li>
        <li @click="toggleNav"><router-link to="/about">About</router-link></li>
        <li @click="toggleNav"><router-link to="/services">Services</router-link></li>
        <li @click="toggleNav"><router-link to="/gallery">Gallery</router-link></li>
        <li @click="toggleNav"><router-link to="/blog">News</router-link></li>
        <li @click="toggleNav"><router-link to="/contact">Contact Us</router-link></li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: "HeaderMobile",
  data: function () {
    return {
      navOpen:false
    }},
  methods: {
    toggleNav() {
      let self=this;
      self.navOpen = !self.navOpen;
    }
  }
}
</script>
