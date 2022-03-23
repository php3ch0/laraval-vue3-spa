<template>
  <div >

    <div v-if="(loading && !noloader)" class="loading">
      <img src="/storage/images/loaders/loading-sm.svg" alt="Loading">
      <small>Loading...</small>
    </div>

    <div v-else>
      <div v-if="this.user && this.user.role=='admin'">

        <div class="widget-edit">
          <div class="button">
            <router-link v-bind:to="'/admin/widgets/' + wid" >
              <i class="fa fa-edit"></i>
            </router-link>
          </div>
          <transition name="fade">
            <div v-html="html" :class="wclass"></div>
          </transition>
        </div>


      </div>
      <div v-else>
        <transition name="fade">
          <div v-html="html" :class="wclass"></div>

        </transition>
      </div>
    </div>




  </div>

</template>

<script>
  import { mapGetters } from 'vuex';
  export default {
    name: "Widget",
    props: {
      name: String, wclass:String, noloader:Boolean
    },
    computed: mapGetters({
      user: 'auth/user'
    }),
    data() {
      return {
        html:null,
        wid:null,
          loading:true
      }
    },
    mounted() {
      let self=this;
      self.$axios.get('/api/widgets/'+self.name).then(function (res) {
        self.wid = res.data.id;
        self.html=res.data.html;
        self.loading=false;
      })
    },
  }
</script>
