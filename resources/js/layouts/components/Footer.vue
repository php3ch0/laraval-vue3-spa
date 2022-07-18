<template>
  <footer id="PageFooter" class="bg-blue-300 p-4">

    <div class="container mx-auto">
      <div class="flex">
        <div class="flex-auto">
          <div class="mb-4">
            <img src="/storage/images/logo-white.webp" class="h-[40px]" alt="Shepway Computers Folkestone computer support and laptop repairs" />
          </div>
          <div class="footer-address">
            <p>
              Shepway Computers<br>
              4 Major Close<br>
              Folkestone<br>
              CT20 3WR
            </p>
          </div>
        </div>
        <div class="flex-auto">
          <h4>Computer Support</h4>
          <ul class="footer-menu">
            <li><router-link to="/services/telephone">Telephone IT Support</router-link></li>
            <li><router-link to="/services/reapirs">Computer & Laptop Repairs</router-link></li>
            <li><router-link to="/services/apple">Apple Support</router-link></li>
            <li><router-link to="services/heathcheck">PC Health Check</router-link></li>
            <li><router-link to="/services/virusremoval">Virus Removals</router-link></li>
            <li><router-link to="/services/callouts">Callouts & Onsite Support</router-link></li>
          </ul>

        </div>
        <div class="flex-auto">

          <h4>Other Services</h4>
          <ul class="footer-menu">
            <li><router-link to="/services/upgrades">Computer Upgrades</router-link></li>
            <li><router-link to="/sales">Computer Sales</router-link></li>
            <li><router-link to="/services/networks">Home Networks</router-link></li>
            <li><router-link to="/services/office365">Office 365</router-link></li>
            <li><router-link to="/services/business">Business IT Support</router-link></li>
            <li><router-link to="/account">Account</router-link></li>
          </ul>

        </div>
        <div class="flex-auto">

          <h4>News and Legal</h4>
          <ul class="footer-menu">
            <li><router-link to="/contact">Contact Us</router-link></li>
            <li><router-link to="/blog">Latest News</router-link></li>
            <li><router-link to="/about">About Us</router-link></li>
            <li><router-link to="/legal/privacy">Privacy Policy</router-link></li>
            <li><router-link to="/legal/terms">Website Terms</router-link></li>
            <li><router-link to="/legal/warranties">Repair Terms</router-link></li>
          </ul>

        </div>
      </div>
    </div>


  </footer>
</template>

<script>
export default {
  name: "PageFooter"
}
</script>
