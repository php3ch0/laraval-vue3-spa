<template>
  <div id="DesktopNav" class="p-4 hidden lg:block xl:block" :class="{'active': menu_active }" @mouseleave="closeMenu">

    <div class="logo-wrap">
      <router-link to="/" class="flex content-center">
        <button class="hamburger hamburger--elastic p-0" :class="{ 'is-active':  menu_active }" @click.prevent="toggleMenu" type="button"
                aria-label="Menu">
              <span class="hamburger-box">
                <span class="hamburger-inner"></span>
              </span>
        </button>
      </router-link>
    </div>

    <div class="divider"></div>

    <nav class="menu">
      <ul class="menutop">
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
    </nav>


  </div>
</template>

<script>
export default {

  data() {
    return {
      menu_active:null
    }
  },

  computed: {
    user() {
      return this.$store.getters.user
    }
  },
  methods: {
    logout() {
      this.$store.dispatch('logout')
        .then(() => {
          this.$router.push({name: 'Login'})
        })
    },
    toggleMenu() {
        let self=this;
        self.menu_active=!self.menu_active;

    },
    closeMenu() {
      let self=this;
      self.menu_active=false;
    }
  }
}
</script>
