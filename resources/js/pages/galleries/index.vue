<template>


  <div id="GalleryPage">


    <div class="container text-center mt-3">
      <Widget name="GalleriesText" />
    </div>

    <div class="container">
      <div class="row justify-content-center mt-3 mb-3">
        <div v-for="gallery in Galleries" class="col-12 col-md-6 col-lg-4">
          <router-link :to="gallery.url">
            <div class="gallery-item">
              <div class="image">
                <img :src="gallery.image_url" :alt="gallery.name" />
              </div>
              <div class="text">
                {{ gallery.name }}
              </div>
            </div>
          </router-link>

        </div>
      </div>
    </div>

  </div>

</template>

<script>

export default {
  name: "gallery.index",

  layout:'default',

  metaInfo () {
    let self = this;
    return {

      title: window.config.appName+' | Photo Galleries',
      meta: [
        {name: 'description',content: 'Pictures and galleries from '+window.config.appName},
      ]
    }
  },

  data() {
    return {
      Galleries: {},
    }
  },
  mounted() {
    this.getGalleries();
  },
  methods: {
    getGalleries() {
      let self=this;
      self.Items={};
      self.$axios.get('/api/galleries?hidden=false').then(function (res) {
        self.Galleries=res.data.results;
      })
    },

  }
}
</script>
