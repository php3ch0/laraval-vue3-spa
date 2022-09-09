<template>

<div id="MobileNav" class="block lg:hidden xl:hidden">

  <div class="container-fluid">
    <div class="flex gap-4">
      <div class="flex-auto self-center">
        <a href="/">
          <img src="/storage/images/logo.png" class="logo" alt="Peter Kifodu Foundation" />
        </a>
      </div>
      <div class="flex-none self-center">
        <div class="ml-3">
          <button class="hamburger hamburger--elastic p-0" :class="{ 'is-active': navOpen }" @click.prevent="toggleNav" type="button"
                  aria-label="Menu">
              <span class="hamburger-box">
                <span class="hamburger-inner"></span>
              </span>
          </button>
        </div>

      </div>
    </div>
  </div>
  <div class="mobileNav" :class="{ 'nav-open': navOpen }">
    <ul class="navbar">
      <li @click="toggleNav"><router-link to="/">Home</router-link></li>
      <li @click="toggleNav"><router-link to="/about">About</router-link></li>
      <li @click="toggleNav"><router-link to="/contact">Contact Us</router-link></li>
    </ul>
  </div>



</div>

</template>

<script>
export default {


  data: () => ({
    navOpen:false,
  }),


  mounted() {
    let self=this;
  },

  methods: {
    toggleNav() {
      let self=this;
      self.navOpen = !self.navOpen;
    }
  }
}
</script>
