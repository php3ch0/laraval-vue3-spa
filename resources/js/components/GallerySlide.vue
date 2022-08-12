<template>

  <div id="gallerySlide">
    <Loading v-if="loading" />
    <template v-else>
      <agile :dots="false" :infinite="true" :autoplay-speed="5000">
        <div v-for="image in gallery.images" class="slide">
         <div class="image-wrap">
           <template v-if="image.link">
             <a :href="image.link" target="_blank">
               <img :src="image_url" :alt="image.alt" />
             </a>
           </template>
           <template v-else>
             <img :src="image_url" :alt="image.alt" />
           </template>

         </div>
        </div>
      </agile>
    </template>
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
    id: Number
  },

  data() {
    return {
      gallery: {},
      loading:{},
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
      })
    }
  }
}
</script>
