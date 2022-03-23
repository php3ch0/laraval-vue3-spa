<template>

  <div id="HeaderImage" class="header-image chevron" :style="'background-image:url(\'/storage/images/headers/'+image+'\');'">

    <div class="title-text p-3">
      <div class="container">
        <div class="row">
          <div class="col-12 col-md-8 col-lg-6">
            <h1>{{ title }}</h1>
          </div>
        </div>

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
