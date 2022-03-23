<template>

  <div id="GallerySlide">

    <carousel v-if="slides.length" :perPageCustom="[[0,1],[500,2],[768, 4], [1024, 5]]" :navigationEnabled="false" :loop="true">
      <slide v-for="slide in slides" :key="slide.id">

        <img :src="slide.image_url" :alt="gallery.title" />


      </slide>
    </carousel>



  </div>

</template>

<script>
import { Carousel, Slide } from 'vue-carousel';

export default {
  name: "GallerySlide",

  components: { Carousel,
    Slide },

  data() {
    return {
      gallery:{id: 0},
      slides: {},
    }},
  props: {
    id: Number,
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
        self.slides = self.gallery.images;

      });
    },
  }
}

</script>
