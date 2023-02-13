<template>
    <div id="BlogPage">

      <teleport to="head">
        <title>Portside Film and Media Recruitment | News and Updates</title>
        <meta name="description" content="The latest news, blogs and project updates from Portside Film and Media Recruitment" />
      </teleport>

      <HeaderImage widget="blogtitle" title="Blog News and Updates from Portside Film and Media Recruitment" imageurl="/storage/images/headers/news.jpg" />


      <div class="container">

        <Loading v-if="loading" />

        <template v-else>

        <div class="py-5 grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

          <div v-for="item in Items" class="blog-item">

            <div class="item-image">
              <router-link :to="item.url">
              <img :src="item.image_url" :alt="item.title" />
              </router-link>
            </div>
            <div class="item-text">
              <div class="title">
                <router-link :to="item.url">
                  <h4>{{ item.title }}</h4>
                </router-link>
              </div>
              <div class="preview">
                {{ item.preview_text }}
              </div>
            </div>

          </div>

        </div>

        <div  class="mt-3 justify-content-center d-flex text-center">
          <pagination v-model="currentPage" :records="totalRows" :per-page="perPage" @paginate="getItems" :options="{chunksNavigation:false}"/>
        </div>

        </template>


       </div>
    </div>
</template>

<script>


import Loading from "../../components/Loading";
export default {
    name: "BlogPage",
  components: {Loading},
  data() {
      return {
        Items: null,
        loading:true,
        currentPage:1,
        perPage: 12,
        totalRows:100,
      }
    },
    mounted() {
      this.getItems();
    },

    methods: {
      getItems() {
        let self = this;
        self.loading=true;
        self.Items = null;
        axios.get('/api/blog?page='+self.currentPage+'&limit='+self.perPage).then(function (res) {
          self.Items = res.data.data;
          self.totalRows = res.data.total;
          self.loading=false;
        })
      },
    }

}
</script>
