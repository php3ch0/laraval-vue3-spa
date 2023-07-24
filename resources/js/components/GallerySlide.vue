<template>

  <div id="gallerySlide">
    <Loading v-if="loading" />
    <template v-else>
      <agile :autoplay-speed="5000" :options="galleryOptions">
        <template v-slot:default>
          <div v-for="image in gallery.images" class="slide">
           <div class="image-wrap">
             <template v-if="image.link">
               <a :href="image.link" target="_blank">
                 <img :src="image.image_url" :alt="image.alt" />
               </a>
             </template>
             <template v-else>
               <div v-if="lightbox" class="lb-link" @click.prevent="toggleLightbox(image.image_url)">
                 <img :src="image.image_url" :alt="image.alt" />
               </div>
               <div v-else>
                 <img :src="image.image_url" :alt="image.alt" />
               </div>

             </template>

           </div>
          </div>
        </template>


        <template #prevButton><img src="/storage/images/gallerynav/prev.svg" alt="Previous" /></template>
        <template #nextButton><img src="/storage/images/gallerynav/next.svg" alt="Next" /></template>

      </agile>


    </template>

    <div v-if="lightbox && showLightbox" id="lightbox">
      <div class="lb-close" @click.prevent="toggleLightbox"><i class="fa-solid fa-xmark"></i></div>
      <div class="lb-image">
        <img :src="lbImage" :alt="lbTitle" />
      </div>
    </div>

  </div>

</template>

<script>
import { VueAgile } from 'vue-agile'
import Loading from "./Loading";

export default {
  name: "GallerySlide",

  components: {
    Loading,
    agile: VueAgile
  },

  props: {
    id: Number,
    lightbox: {
      type: Boolean,
      default: false
    }
  },

  data() {
    return {
      gallery: {},
      loading:{},
      showLightbox:false,
      lbImage:null,
      lbTitle:"The Picnic Hut new Romney, Kent Catering Company",
      galleryOptions: {
        navButtons: true,
        responsive: [
          {
            breakpoint: 600,
            settings: {
              navButtons: true,
              dots: false,
              infinite: true,
              slidesToShow:1
            }
          },
          {
            breakpoint: 900,
            settings: {
              navButtons: true,
              dots: false,
              infinite: true,
              slidesToShow:2
            }
          },

          {
            breakpoint: 1100,
            settings: {
              navButtons: true,
              dots: false,
              infinite: true,
              slidesToShow:3
            }
          }
        ]
      }
    }
  },

  mounted() {
    let self=this;
    self.getGallery();
  },

  methods: {
    getGallery() {
      let self=this;
      self.loading=true;
      axios.get('/api/galleries/'+self.$props.id).then(function(res) {
        self.gallery=res.data;
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
