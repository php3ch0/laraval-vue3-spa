<template>


<div v-if="Service" id="ServicesPage">


  <div class="container pt-3 pb-3">
    <div  class="row">
      <div class="col-12 col-lg-7 text-center text-lg-start">
        <div v-html="Service.text"></div>
        <div class="pt-3 pb-3">

          <router-link  to="/services" class="btn btn-secondary btn-lg mb-2"><i class="fas fa-arrow-left"></i> Back To Services</router-link>
          <router-link to="/contact" class="btn btn-primary btn-lg mb-2"><i class="fas fa-phone-alt"></i> Contact Us</router-link>
        </div>

      </div>
      <div class="col-12 col-lg-5">
        <div class="ml-lg-3">
          <div v-if="!Service.gallery_id && !isGalleryLoaded" class="mb-3">
            <img :src="Service.image_icon_url" class="img-fluid" :alt="Service.name" />
          </div>
          <div v-else class="services-gallery-wrap">
            <agile v-if="isGalleryLoaded" class="thumbnails mt-3 mb-3" ref="thumbnails" :options="options2">
              <div class="slide slide--thumbniail" v-for="(slide, index) in slides" :key="index" :class="`slide--${index}`" @click="$refs.thumbnails.goTo(index); $refs.main.goTo(index)"><img :src="slide"/></div>

              <template slot="prevButton"><i class="fas fa-chevron-left"></i></template>
              <template slot="nextButton"><i class="fas fa-chevron-right"></i></template>
            </agile>
            <agile v-if="isGalleryLoaded" class="main" ref="main" :options="options1">
              <div class="slide" v-for="(slide, index) in slides" :key="index" :class="`slide--${index}`"><img :src="slide"/></div>
            </agile>


          </div>

        </div>
      </div>
    </div>


  </div>










</div>
</template>

<script>

    import { VueAgile } from 'vue-agile';
    import Widget from "../../components/Widget";
    import ServiceHeader from "./components/ServicesHeader";

export default {
    name:'serviceViews',

  metaInfo: {
    title: window.config.appName+' | Services',
    meta: [
      { name: 'description', content: '' }
    ]
  },
    beforeRouteUpdate (to, from, next) {
        this.getService(to.params.slug);
        next();
    },

    components: {
        ServicesHeader,
        Widget,
        agile: VueAgile
    },

    data() { return {
      Service: null,
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


    mounted() {
        this.getService(this.$route.params.slug);
    },
    methods: {
        getService(slug) {
            let self=this;
            self.isGalleryLoaded=false;
            self.slides=[];
            self.$axios.get('/api/services/'+slug).then(function (res) {
                self.Service=res.data;
                document.getElementsByTagName('meta').namedItem('description').setAttribute('content', self.Service.short_text+' covering Maidstone, Medway, Ashford and South East Kent');
                document.title = window.config.appName+' | '+self.Service.name;
            }).then( function() {
                if(self.Service && self.Service.gallery_id) {
                    self.$axios.get('/api/galleries/'+self.Service.gallery_id).then(function (response) {

                        let images = response.data.results.images;
                        images.forEach(function(im,index) {
                            self.slides.unshift(im.image_url);
                        });
                            self.isGalleryLoaded=true;

                    });
                }
            })
        },
    }

}
</script>
<style lang="scss">
  .services-gallery-wrap {
    .agile__slides {
      align-items: flex-start !important;
    }
    .thumbnails {
      margin: 0 -5px;
      width: calc(100% + 10px);
    }

    .agile__nav-button {
      background: transparent;
      border: none;
      color: #ccc;
      cursor: pointer;
      font-size: 24px;
      transition-duration: 0.3s;
    }
    .thumbnails .agile__nav-button {
      position: absolute;
      top: 50%;
      -webkit-transform: translateY(-50%);
      transform: translateY(-50%);
    }
    .thumbnails .agile__nav-button--prev {
      left: -45px;
    }
    .thumbnails .agile__nav-button--next {
      right: -45px;
    }
    .agile__nav-button:hover {
      color: #888;
    }
    .agile__dot {
      margin: 0 10px;
    }
    .agile__dot button {
      background-color: #eee;
      border: none;
      border-radius: 50%;
      cursor: pointer;
      display: block;
      height: 10px;
      font-size: 0;
      line-height: 0;
      margin: 0;
      padding: 0;
      transition-duration: 0.3s;
      width: 10px;
    }
    .agile__dot--current button, .agile__dot:hover button {
      background-color: #888;
    }

    .slide {
      align-items: center;
      box-sizing: border-box;
      color: #fff;
      display: flex;
      justify-content: center;
    }
    .slide--thumbniail {
      cursor: pointer;
      height: 100px;
      padding: 0 5px;
      transition: opacity 0.3s;
    }
    .slide--thumbniail:hover {
      opacity: 0.75;
    }
    .slide img {
      height: 100%;
      -o-object-fit: cover;
      object-fit: cover;
      -o-object-position: top;
      object-position: top;
      width: 100%;
    }
  }
  .main {
    .agile__list {
      max-height:500px;
    }
  }

</style>
