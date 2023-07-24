<template>
  <div id="HeaderImageSmall" class="flex relative" ref="header-wrap">
  <div class="container text-center">
    <h1>{{ title}}</h1>
  </div>


  </div>
</template>

<script>
export default {
    name: "HeaderImageSmall",
    props: {
        title:String,
    }
}
</script>
