<template>

  <div id="gallerySlide">
    <Loading v-if="loading" />
    <template v-else>
      <agile :autoplay-speed="5000" :options="galleryOptions">
        <template v-slot:default>
          <div v-for="image in gallery" class="slide">
           <div class="image-wrap">
               <div class="lb-link" @click.prevent="toggleLightbox(image.image_url)">
                 <img :src="image.image_url" :alt="image.alt" />
               </div>
           </div>
          </div>
        </template>


        <template #prevButton><img src="/storage/images/gallerynav/prev.svg" alt="Previous" /></template>
        <template #nextButton><img src="/storage/images/gallerynav/next.svg" alt="Next" /></template>

      </agile>


    </template>

    <div id="lightbox" v-if="showLightbox">
      <div class="lb-close" @click.prevent="toggleLightbox"><i class="fa-solid fa-xmark"></i></div>
      <div class="lb-image">
        <img :src="lbImage" :alt="lbTitle" />
      </div>
    </div>

  </div>

</template>

<script>
import { VueAgile } from 'vue-agile'

export default {
  name: "BlogGallerySlide",

  components: {
    agile: VueAgile
  },

  props: {
    id: Number
  },

  data() {
    return {
      gallery: {},
      loading:{},
      showLightbox:false,
      lbImage:null,
      lbTitle:"Peter Kifodu Foundation News Blog Image",
      galleryOptions: {
        navButtons: true,
        responsive: [
          {
            breakpoint: 600,
            settings: {
              navButtons: true,
              dots: false,
              infinite: true,
              slidesToShow:2
            }
          },
          {
            breakpoint: 900,
            settings: {
              navButtons: true,
              dots: false,
              infinite: true,
              slidesToShow:3
            }
          },

          {
            breakpoint: 1100,
            settings: {
              navButtons: true,
              dots: false,
              infinite: true,
              slidesToShow:4
            }
          }
        ]
      }
    }
  },

  mounted() {
    let self=this;
    self.getImages();
  },

  methods: {
    getImages() {
      let self=this;
      self.loading=true;
      axios.get('/api/blog/'+self.$props.id).then(function(res) {
        self.gallery=res.data.images;
        self.loading=false;
      })
    },
    toggleLightbox(image=null) {
      let self =this;
      if(!self.showLightbox) {
        self.showLightbox=true;
        self.lbImage=image;
      } else {
        self.showLightbox=false;
      }
    }
  }
}
</script>
