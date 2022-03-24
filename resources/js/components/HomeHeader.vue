<template>

  <div id="HomeHeader">

    <carousel v-if="slides.length" :perPageCustom="[[0, 1]]" :paginationEnabled="false" :navigationEnabled="false" :loop="true" autoplay :autoplayTimeout="8000" :autoplayHoverPause="false" >
      <slide v-for="slide in slides" :key="slide.id">

        <img :src="slide.image_url" :alt="slide.caption" />


      </slide>
    </carousel>

    <div class="text">
      <div class="container">
        <div class="p-3">

              <div class="header">
                <h1>Planning & Development Consultants</h1>
              </div>


        </div>


      </div>

    </div>

  </div>

</template>

<script>
import { Carousel, Slide } from 'vue-carousel';

export default {
  name: "HomeHeader",

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
  computed: {
    navigationNext() {

      return '<img src="/storage/images/icons/chev-right.svg" alt="Next"/>';
    },
    navigationPrev() {

      return '<img src="/storage/images/icons/chev-left.svg" alt="Prev"/>';
    },
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
