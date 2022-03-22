<template>
    <header id="Header">
      <div class="container">
        <div class="row">
          <div class="col-auto align-self-center">
            <router-link to="/"><img src="/storage/images/logo.svg" class="logo" alt="Print Junction Trade System" /></router-link>
          </div>
          <div class="col align-self-center text-end">
            <div class="contact"><a href="tel:01233624462"><i class="fas fa-phone"></i> 01233 624462</a></div>
            <div class="contact"><a href="mailto:trade@print-junction.co.uk"><i class="fas fa-at"></i> trade@print-junction.co.uk</a></div>
          </div>
        </div>
      </div>


    </header>
</template>

<script>

export default {
  name: "Header",
}
</script>
