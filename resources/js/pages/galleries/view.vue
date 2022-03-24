<template>

  <div id="GalleryViewPage">


    <div class="container mt-3 mb-3 pt-4 pb-4">
      <div class="text-center mt-3 mb-3">
        <h1>{{ gallery.name }}</h1>
      </div>

      <div v-if="gallery.id" class="container mt-3 mb-3">
        <GalleryView :id="gallery.id" />
      </div>
      <LoadingSm v-else />

      <div class="mt-3 mb-3 text-center">
        <router-link to="/galleries" class="btn btn-primary">Go Back</router-link>
      </div>
    </div>





  </div>

</template>

<script>
import GalleryView from "../../components/GalleryView";
import LoadingSm from "../../components/LoadingSm";

export default {
  name: "gallery.view",
  components: {LoadingSm, GalleryView},



  data() {
    return {
      gallery: {id: 0},
      seo: {
        title:window.config.appName+' |  Galleries',
        image:null,
        url:null,
        description:'View photos and pictures from '+window.config.appName,
      },
    }},
  mounted() {
    let self=this;
    self.getGallery();
    self.seo.url = window.config.appURL+'/'+self.$route.fullPath;
  },
  methods: {
    getGallery() { //load page categories
      let self = this;
      self.gallery={};
      self.$axios.get('/api/galleries/'+self.$route.params.slug).then(function (res) {
        self.gallery = res.data.results;
        self.seo.title = res.data.results.name;
      });
    },
  }
}
</script>
