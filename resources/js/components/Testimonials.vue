<template>

  <div id="TestimonialsSlide">
    <div class="container">
      <div class="pt-4 pb-4 lg:flex title">
        <div class="flex-auto">
          <h2 class="cursive">
            <span class="inline xl:hidden">Testimonials</span>
            <span class="hidden xl:inline">What People Say About Us</span>
          </h2>
        </div>


      </div>
      <div class="pb-4">

        <Loading v-if="loading" />

        <template v-else>
          <agile :autoplay-speed="5000" :options="galleryOptions">
            <template v-slot:default>
              <div v-for="testimonial in testimonials" class="slide">
                <div class="testimonial-wrap self-start">
                  <div class="name">{{testimonial.name}}</div>
                  <div class="rating">
                    <star-rating v-model:rating="testimonial.score" :show-rating="false" :star-size="25" :read-only="true"></star-rating>
                  </div>
                  <div class="text my-3" v-html="testimonial.review"></div>

                </div>
              </div>
            </template>


            <template #prevButton><img src="/storage/images/gallerynav/prev.svg" alt="Previous" /></template>
            <template #nextButton><img src="/storage/images/gallerynav/next.svg" alt="Next" /></template>

          </agile>


        </template>

      </div>
    </div>

  </div>

</template>

<script>

import { VueAgile } from 'vue-agile'
import StarRating from 'vue-star-rating';

export default {
  name: "Testimonials",

  components: {
    StarRating,
    agile: VueAgile
  },

  data() {
    return {
      testimonials:{},
      loading:true,
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
              slidesToShow:2
            }
          },

          {
            breakpoint: 1300,
            settings: {
              navButtons: true,
              dots: false,
              infinite: true,
              slidesToShow:3
            }
          },
          {
            breakpoint: 1600,
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
    self.getTestimonials();
  },

  methods: {
    getTestimonials() {
      let self=this;
      axios.get('/api/testimonials/').then(function(res) {
        self.testimonials = res.data.results;
        self.loading=false;
      }).catch(e=> {
        console.log(e.response.data);
      })
    },
  }

}
</script>
