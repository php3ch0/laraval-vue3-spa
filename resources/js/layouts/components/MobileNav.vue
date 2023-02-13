<template>

<div id="MobileNav" class="block lg:hidden xl:hidden">

  <div class="container-fluid">
    <div class="flex gap-4">
      <div class="flex-auto self-center">
        <a href="/">
          <img src="/storage/images/logo.png" class="logo" alt="Portside Recruitment" />
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
      <li><router-link @click="closeMenu" to="/" class="">Home</router-link></li>
      <li><router-link @click="closeMenu" to="/about" class="">About Us</router-link></li>
      <li><router-link @click="closeMenu" to="/clients" class="">Clients</router-link></li>
      <li><router-link @click="closeMenu" to="/candidates" class="">Candidates</router-link></li>
      <li><router-link @click="closeMenu" to="/membership" class="">Membership</router-link></li>
      <li><router-link @click="closeMenu" to="/accreditation" class="">Accreditation</router-link></li>
      <li><router-link @click="closeMenu" to="/blog" class="">News / Blog</router-link></li>
      <li><router-link @click="closeMenu" to="/contact" class="">Contact Us</router-link></li>
      <li><router-link @click="closeMenu" to="/account" class="">Account</router-link></li>
      <li v-if="user && user.role==='admin'"><router-link @click="closeMenu" to="/admin" class="">Admin</router-link></li>
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
