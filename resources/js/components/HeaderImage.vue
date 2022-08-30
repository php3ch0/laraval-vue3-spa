<template>
  <div id="HeaderImage" class="h-[350px] flex relative">

    <div class="header-image">
      <img :src="imageurl" :alt="title" />
    </div>

    <div v-if="widget" class="widget-header container mx-auto self-center">
      <div class="flex">
        <div class="w-[100%] lg:w-[80%] xl:w-[60%]">
          <Widget :name="widget" />
        </div>
      </div>

    </div>

    <div v-else class="text max-w-7xl text-center self-center mx-auto text-center" style="text-shadow: 0px 0px 4px #000000;">
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
        imageurl:String,
        widget:String
    }
}
</script>
