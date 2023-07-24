<template>
  <div id="DesktopNav" class="p-4 hidden lg:block xl:block" :class="{'active': menu_active }" @mouseleave="closeMenu">
    <div class="mx-3 flex gap-4 content-center">
      <div class="flex-none logo-wrap self-center">
        <router-link to="/" class="flex content-center">
          <img src="/storage/images/logo_trans.png" class="logo mr-3" alt="The Whichcote Arms" />
        </router-link>
      </div>
      <div class="flex-none self-center">
        <router-link  to="/">
          <img class="inline xl:hidden" src="/storage/images/logo_text_trans.png" alt="The Whichcote Arms in Osbournby" style="height:75px;" />
          <h1 class="mb-0 hidden xl:inline">The Whichcote Arms</h1>
        </router-link>
      </div>
      <div class="ml-auto self-center">
        <nav class="menu">
          <ul class="menutop">
            <li class="hidden xl:inline"><router-link  to="/" class="">Home</router-link></li>
            <li><router-link  to="/restaurant" class="">Restaurant</router-link></li>

            <li><router-link  to="/rooms" class="">Rooms</router-link></li>
            <li><router-link  to="/garden" class="">Bar<span class="hidden 2xl:inline"> & Garden</span></router-link></li>
            <li><router-link  to="/farmshop" class=""><span class="hidden xl:inline">Farm </span>Shop</router-link></li>
            <li><router-link  to="/cafe" class="">Cafe</router-link></li>
            <li><router-link  to="/contact" class="">Contact</router-link></li>
          </ul>
        </nav>
      </div>
    </div>







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

  created () {
    window.addEventListener('scroll', this.pageScroll);
  },
  unmounted () {
    window.removeEventListener('scroll', this.pageScroll);
  },

  methods: {
    pageScroll (event) {
      let self=this;

      const speed = 1;
      let pos = window.pageYOffset;

      if(pos > 110) {
       document.getElementById('DesktopNav').classList.add('solid');
      } else {
        document.getElementById('DesktopNav').classList.remove('solid');
      }

    }

  }
}
</script>
