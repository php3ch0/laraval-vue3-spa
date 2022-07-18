<template>
  <div id="HeaderImage" class="h-[350px] flex" :style="'background-image:url('+imageurl+'); background-size:cover;'">
      <div class="text max-w-7xl text-center self-center mx-auto text-center" style="text-shadow: 0px 0px 4px #000000;">
          <h1 class="text-white animated delay-300 fadeInUp" v-if="title">{{ title }}</h1>
          <p class="text-white animated fadeInUp delay-600" v-if="subtitle">{{ subtitle }}</p>
      </div>
  </div>
</template>

<script>
export default {
    name: "HeaderImage",
    props: {
        title:String,
        subtitle:String,
        imageurl:String
    }
}
</script>
