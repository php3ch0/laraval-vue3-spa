<template>

  <div id="HeaderImage" class="header-image chevron" :style="'background-image:url(\'/storage/images/headers/'+image+'\');'">

    <div class="title-text p-3">
      <div class="container">

            <h1>{{ title }}</h1>


      </div>
    </div>

  </div>

</template>

<script>
export default {
  name: "HeaderImageChevron",
  props: {
    image: String,
    title: String
  }
}
</script>
