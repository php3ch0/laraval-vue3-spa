<template>
  <div id="DesktopNav" class="p-4 hidden lg:block xl:block">

    <div class="logo-wrap">
      <router-link to="/" class="flex gap-4">
        <img src="/storage/images/logo_icon.png" class="logo self-center" alt="Peter Kifodu Foundation" />
        <div class="self-center logo-text">
          <h3>Peter Kifodu</h3>
          <p>Foundation</p>
        </div>
      </router-link>
    </div>

    <div class="divider"></div>

    <nav class="menu">
      <ul class="menutop">
        <li><router-link @click="toggleMenu" to="/" class="">Home</router-link></li>
        <li>
          <a href="#" @click.prevent="toggleMenu('menu_mission')">Our Mission</a>
          <div ref="menu_mission" class="dd-dropdown">
            <ul>
              <li><router-link to="/about" class="">About The Foundation</router-link></li>
              <li><router-link to="/projects" class="">Our Projects</router-link></li>
              <li><router-link to="/founders" class="">Our Founders</router-link></li>
              <li><router-link to="/blog" class="">News and Updates</router-link></li>
            </ul>
          </div>
        </li>
        <li> <a href="#" @click.prevent="toggleMenu('menu_involved')">Get Involved</a>
          <div ref="menu_involved" class="dd-dropdown">
            <ul>
              <li><router-link @click="toggleMenu" to="/contact" class="">Your Voice</router-link></li>
              <li><router-link @click="toggleMenu" to="/contact" class="">Opportunities</router-link></li>
              <li><router-link @click="toggleMenu" to="/contact" class="">Ways To Donate</router-link></li>
            </ul>
          </div>
        </li>
        <li><router-link @click="toggleMenu" to="/donate" class="">Donate</router-link></li>
        <li><router-link @click="toggleMenu" to="/contact" class="">Contact Us</router-link></li>
        <li v-if="user.id && user.role==='admin'"><router-link @click="toggleMenu" to="/admin" class="">Admin</router-link></li>
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
    toggleMenu(menu) {
        let self=this;
        self.$refs['menu_mission'].classList.remove('active');
        self.$refs['menu_involved'].classList.remove('active');
        if(menu) {
          self.$refs[menu].classList.add('active');
        }

    }
  }
}
</script>
