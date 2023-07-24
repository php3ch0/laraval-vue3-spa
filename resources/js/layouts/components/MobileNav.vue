<template>

<div id="MobileNav" class="block lg:hidden xl:hidden">

  <div class="container-fluid">
    <div class="flex gap-4">
      <div class="flex-auto self-center">
        <a href="/">
          <img src="/storage/images/logo_text.png" class="logo" alt="Whichcote Arms" />
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
      <li><router-link @click="closeMenu"  to="/" class="">Home</router-link></li>
      <li><router-link @click="closeMenu"  to="/restaurant" class="">Restaurant</router-link></li>
      <li><router-link @click="closeMenu"  to="/rooms" class="">Rooms</router-link></li>
      <li><router-link @click="closeMenu"  to="/garden" class=""> Bar & Garden</router-link></li>
      <li><router-link @click="closeMenu"  to="/farmshop" class="">Farm Shop</router-link></li>
      <li><router-link @click="closeMenu"  to="/cafe" class="">Cafe</router-link></li>
      <li><router-link @click="closeMenu"  to="/contact" class="">Contact Us</router-link></li>
    </ul>
  </div>



</div>

</template>

<script>
export default {


  data: () => ({
    navOpen:false,
  }),

  computed: {
    user() {
      return this.$store.getters.user
    }
  },


  mounted() {
    let self=this;
  },

  methods: {
    toggleNav() {
      let self=this;
      self.navOpen = !self.navOpen;
    },
    closeMenu() {
      let self=this;
      self.navOpen = false;
    }
  }
}
</script>
