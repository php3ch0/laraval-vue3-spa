<template>

  <div id="HeaderImage" class="header-image chevron" :style="'background-image:url(\'/storage/images/headers/'+image+'\');'">

    <div class="title-text p-3">
      <div class="container">

            <h1>{{ title }}</h1>
        <p v-if="subtitle">{{ subtitle }}</p>
        <router-link v-if="button" class="btn btn-primary btn-lg" to="/book">Book Online</router-link>

      </div>
    </div>

  </div>

</template>

<script>
export default {
  name: "HeaderImageChevron",
  props: {
    image: String,
    title: String,
    subtitle: String,
    button:Boolean
  }
}
</script>
