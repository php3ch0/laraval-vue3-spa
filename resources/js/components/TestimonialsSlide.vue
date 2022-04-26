<template>

  <div id="TestimonialsSlide">

    <carousel v-if="testimonials.length" :perPageCustom="[[0,1],[1024, 2],[1400,3]]" :navigationEnabled="true" :loop="true" autoplay :autoplayTimeout="8000" :navigation-next-label="navigationNext" :navigation-prev-label="navigationPrev">
      <slide v-for="test in testimonials" :key="test.id">


            <div class="testimonial">
                <div class="quote"><i class="fas fa-quote-left fa-3x"></i></div>
                <div class="text">
                  {{ test.text }}
                </div>
                <div class="name">
                  {{ test.name }}
                </div>
            </div>

      </slide>
    </carousel>



  </div>

</template>

<script>
import { Carousel, Slide } from 'vue-carousel';

export default {
  name: "TestimonialsSlide",

  components: { Carousel,
    Slide },

  data() {
    return {
      testimonials: {},
    }},
  computed: {
    navigationNext() {

      return '<img src="/storage/images/icons/chev-right-white.svg" alt="Next"/>';
    },
    navigationPrev() {

      return '<img src="/storage/images/icons/chev-left-white.svg" alt="Prev"/>';
    },
  },
  mounted() {
    this.getTestimonials();
  },
  methods: {
    getTestimonials() { //load page categories
      let self = this;
      self.testimonials={};
      self.$axios.get('/api/testimonials').then(function (res) {
        self.testimonials = res.data;

      });
    },
  }
}

</script>
