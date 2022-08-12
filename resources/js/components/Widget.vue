<template>
  <div id="Widget">

      <Loading v-if="loading" />

      <template v-else>

          <template v-if="widget.type==='TEXT'">
              <template v-if="user && user.role==='admin'">

                  <div class="widget admin-widget">
                      <div class="controls text-right">
                          <router-link :to="'/admin/widgets/'+widget.id"><i class="fa-solid fa-pen-to-square"></i></router-link>
                      </div>
                      <div v-html="widget.html" :class="$props.class" :style="$props.style">
                      </div>
                  </div>

              </template>
              <template v-else>
                  <div class="widget" v-html="widget.html" :class="$props.class" :style="$props.style">
                  </div>
              </template>

          </template>

          <template v-if="widget.type==='IMAGE'">
              <template v-if="user && user.role==='admin'">

                  <div class="widget admin-widget">
                      <div class="controls text-right">
                          <router-link :to="'/admin/widgets/'+widget.id"><i class="fa-solid fa-pen-to-square"></i></router-link>
                      </div>
                      <img :src="widget.image_url" :alt="widget.alt" :class="$props.class" :style="$props.style" />
                  </div>

              </template>
              <template v-else>
                  <div class="widget">
                      <img :src="widget.image_url" :alt="widget.alt" :class="$props.class" :style="$props.style" />
                  </div>

              </template>

          </template>





      </template>

  </div>
</template>

<script>

export default {
  name: 'Widget',

  props: {
    name:  { type: String, default:null },
    class: { type: String, default:null },
    style: { type: String, default:null }
  },

    data() {
        return {
            widget:{},
            loading:true
        }
    },

    computed: {
      user() {
        return this.$store.getters.user
      },
    },

    mounted() {
      let self=this;

      self.getWidget();
    },

    methods: {
      getWidget() {
          let self=this;
          self.loading=true;
          axios.get('/api/widgets/'+self.$props.name).then(function(res) {
              self.widget = res.data;
              self.loading=false;
          }).catch(e=> {
              console.log(e.response.data);
          });
      }

    }


}
</script>
