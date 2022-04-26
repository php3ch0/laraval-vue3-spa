<template>

  <div id="HeaderImage" class="header-image chevron services-header" :style="'background-image:url(\''+image+'\');'">

    <div class="title-text p-3">
      <div class="container">

        <div class="row justify-content-center">
          <div class="col-12 col-lg-8 col-xl-6">
            <h1>{{ title }}</h1>
            <p v-if="subtitle">{{ subtitle }}</p>
            <button @click.prevent="goToBooking" class="btn btn-lg btn-primary">Book Online Now</button>
          </div>
        </div>




      </div>
    </div>

  </div>

</template>

<script>
export default {
  name: "ServiceHeaderImageChevron",
  props: {
    image: String,
    title: String,
    subtitle: String

  },
  methods: {
    goToBooking() {
      this.$emit('goToBooking');
    }
  }
}
</script>
