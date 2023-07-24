<template>

  <div id="GalleryView">
    <agile v-if="isGalleryLoaded" class="main" ref="main" :options="options1">
      <div class="slide" v-for="(slide, index) in slides" :key="index" :class="`slide--${index}`"><img :src="slide"/></div>
    </agile>
    <agile v-if="isGalleryLoaded" class="thumbnails mt-3 mb-3" ref="thumbnails" :options="options2">
      <div class="slide slide--thumbniail" v-for="(slide, index) in slides" :key="index" :class="`slide--${index}`" @click="$refs.thumbnails.goTo(index); $refs.main.goTo(index)"><img :src="slide"/></div>

      <template slot="prevButton"><i class="fas fa-chevron-left"></i></template>
      <template slot="nextButton"><i class="fas fa-chevron-right"></i></template>
    </agile>

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
      isGalleryLoaded:false,
      options1: {
        dots: false,
        fade: true,
        navButtons: false },
      options2: {
        autoplay: true,
        centerMode: true,
        dots: false,
        navButtons: false,
        slidesToShow: 3,
        responsive: [{
          breakpoint: 600,
          settings: {
            slidesToShow: 3
          }
        },
          {
            breakpoint: 1000,
            settings: {
              navButtons: false
            }
          }]
      },
      slides: []
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
      axios.get('/api/galleries/'+self.id).then(function (res) {
        self.gallery = res.data;

        //sort out the images
        self.gallery.images.forEach(function(im,index) {
          self.slides.unshift(im.image_url);
        });

        self.isGalleryLoaded=true;

      });
    },
  }
}

</script>
