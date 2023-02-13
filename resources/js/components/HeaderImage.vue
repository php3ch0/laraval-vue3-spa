<template>
  <div id="HeaderImage" class="h-[350px] flex relative">

    <div class="header-image">
      <img :src="imageurl" :alt="title" />
    </div>

    <div v-if="widget" class="widget-header container mx-auto self-center">
      <div class="grid grid-cols-12 gap-4 xl:px-5">
        <div class="col-span-12 hidden lg:inline lg:col-span-5 lg:order-1 self-center">
          <img class="logo" src="/storage/images/logo_border.png" alt="Portside Film and Media Recruitment" />
        </div>
        <div class="col-span-12 lg:col-span-7 lg:order-0 self-center">
          <Widget :name="widget" />
        </div>

      </div>

    </div>

    <div v-else class="widget-header container mx-auto self-center">
      <div class="grid grid-cols-12 gap-4 lg:px-5">
        <div class="col-span-12 hidden lg:inline lg:col-span-5 lg:order-1 self-center">
          <img class="logo" src="/storage/images/logo_border.png" alt="Portside Film and Media Recruitment" />
        </div>
        <div class="col-span-12 lg:col-span-7 lg:order-0 self-center">
          <h1 class="text-white animated delay-300 fadeInUp" v-if="title">{{ title }}</h1>
          <p class="text-white animated fadeInUp delay-600" v-if="subtitle">{{ subtitle }}</p>
        </div>

      </div>

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
