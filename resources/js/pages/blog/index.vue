<template>
  <div id="BlogIndex">




  <div id="top" class="container mt-4">

  <div class="row justify-content-center">
    <div v-for="Item in Items" class="col-12 col-md-6 col-lg-4">
      <item :id="Item.id"></item>
    </div>
  </div>

  </div>

    <div class="mt-3 justify-content-center d-flex text-center">
      <b-pagination size="md" :total-rows="totalRows" v-model="Page" :per-page="perPage" @input="getBlogs(Page)">
      </b-pagination>
    </div>

  </div>

</template>

<script>
  import Item from './components/item';
  import HeaderImageChevron from "../../components/HeaderImageChevron";

  let VueScrollTo = require('vue-scrollto');

  export default {
    layout: 'default',
    name:'BlogIndex',
    components: {HeaderImageChevron, Item },

      metaInfo () {
          return {
              title: window.config.appName+' | News Blog',
              meta: [
                  {
                      name: 'description',
                      content: 'Read more about the latest news and information from App Name'
                  },
              ]
          }
      },

    data() {
      return {
        Items: {},
        Page:1,
        perPage: 24,
        totalRows:100,
      }
    },
    mounted() {
     this.getBlogs();
    },

    methods: {
      getBlogs() {
        let self=this;
        self.Items={};
        self.$axios.get('/api/blog?page='+(parseInt(self.Page)-1)).then(function (res) {
          self.Items=res.data.posts;
          self.totalRows=res.data.total;

          VueScrollTo.scrollTo('#BlogIndex',{
            container: 'body',
            easing: 'ease-in',
            offset: 0,
            force: true,
            cancelable: true}
            );
        })
      }
    }

  }

</script>
