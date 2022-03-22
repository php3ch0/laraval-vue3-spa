<template>

  <footer id="Footer">

      <div class="bg-grey">
        <div class="container">
        <h4>Get in touch</h4>
        <p>Monday - Friday: 08:00 - 17:00</p>
        <p><a href="tel:01233624462">01233 624462</a></p>
        <p><a href="mailto:info@print-junction.co.uk">info@print-junction.co.uk</a></p>
        <p>Cobbs Wood House, Chart Road, Ashford, Kent,  TN23 1EP</p>
        </div>
      </div>
      <div class="p-3 text-center bg-white">
        <router-link to="/terms/privacy">Privacy Policy</router-link> | <router-link to="/terms/terms">Terms & Conditions</router-link> | Copyright Print Junction Limited 2021
      </div>

  </footer>

</template>

<script>
export default {
  name: "Footer"
}
</script>
