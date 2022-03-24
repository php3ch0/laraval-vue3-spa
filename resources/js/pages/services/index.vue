<template>
<div id="ServicesPage" :key="$route.fullPath">


      <div class="container">
        <div class="pt-3 pb-3">
          <div class="container">
            <div class="mt-3 mb-3 text-center">
              <Widget  name="ServicesText" class=""></Widget>
            </div>

            <div v-if="Services" class="row flex-row justify-content-center">

              <div v-for="Service in Services" class="col-12 col-md-6 col-lg-4 col-xl-4">
                <router-link :to="'/services/'+Service.slug">
                  <div class="flip-card m-2">
                    <div class="flip-card-inner">
                      <div class="flip-card-front">
                        <div class="service-wrap">
                          <div class="image">
                            <img :src="Service.image_icon_url" :alt="Service.name" />
                          </div>
                          <div class="name">
                            {{ Service.name }}
                          </div>
                        </div>
                      </div>
                      <div class="flip-card-back">
                        <div class="p-3">
                          <h3>{{ Service.name }}</h3>
                          <p>{{ Service.short_text }}</p>
                          <button class="btn btn-primary">More Info</button>
                        </div>

                      </div>
                    </div>
                  </div>
                </router-link>
              </div>

            </div>
          </div>
        </div>
      </div>






</div>
</template>

<script>


export default {
  name:'services',
  metaInfo: {
    title: window.config.appName+' | Services',
    meta: [
      { name: 'description', content: '' }
    ]
  },

    data() { return {
      Services: null,
    }},

    watch: {
      $route: function() {
        let self=this;
        self.getServices();
      }
    },


    mounted() {
        this.getServices();

    },
    methods: {
        getServices() {
            let self=this;
            self.$axios.get('/api/services').then(function (res) {
                self.Services=res.data.results;
            })
        },
    }

}
</script>
