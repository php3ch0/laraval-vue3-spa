<template>

  <div id="GalleryView">
    <div v-if="(title && title.length)" class="text-center">
      <h3>{{ title }}</h3>
    </div>

    <div v-if="(gallery && gallery.images)" class="gallery-wrap">
      <agile v-if="slides.length" class="main" ref="main" :options="options1">
        <div class="slide" v-for="(slide, index) in slides" :key="index" :class="`slide--${index}`"><img :src="slide" :alt="gallery.title"/></div>
        <template slot="prevButton"><i class="fas fa-chevron-left"></i></template>
        <template slot="nextButton"><i class="fas fa-chevron-right"></i></template>
      </agile>

      <agile v-if="(slides.length >1)" class="thumbnails mt-3 mb-3" ref="thumbnails" :options="options2">
        <div class="slide slide--thumbniail" v-for="(slide, index) in slides" :key="index" :class="`slide--${index}`" @click="$refs.thumbnails.goTo(index); $refs.main.goTo(index)"><img :src="slide" :alt="gallery.title "/></div>
      </agile>
    </div>

  </div>

</template>

<script>
import { VueAgile } from 'vue-agile';

export default {
  name: "GalleryView",

  components: {agile: VueAgile },

  data() {
    return {
      gallery:{id: 0},
      options1: {
        dots: false,
        fade: true,
        autoplay: true,
        navButtons: true },
      options2: {
        autoplay: true,
        centerMode: true,
        dots: false,
        navButtons: false,
        slidesToShow: 3,
        responsive: [
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 5 } },
          {
            breakpoint: 1000,
            settings: {
              navButtons: false } }] },
      slides: [],
    }},
  props: {
    id: String,
    title: String
  },
  mounted() {
    this.getGallery();
  },
  methods: {
    getGallery(id) { //load page categories
      let self = this;
      self.gallery={};
      self.$axios.get('/api/galleries/'+self.id).then(function (res) {
        self.gallery = res.data.results;

        //sort out the images
        self.gallery.images.forEach(function(im,index) {
          self.slides.unshift(im.image_url);
        });

      });
    },
  }
}

</script>
