<template>
    <div id="BlogPage">

      <teleport to="head">
        <title>Peter Kifodu Foundation | news and Updates</title>
        <meta name="description" content="The latest news, blogs and project updates from the Peter Kifodu Foundation" />
      </teleport>

      <HeaderImage widget="blogtitle" title="Blog News and Updates from the Peter Kifodu Foundation projects" imageurl="/storage/images/headers/news.webp" />


      <div class="container">

        <div class="pt-4 pb-4 grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

          <div v-for="item in Items" class="project-item">

            <div class="item-image">
              <router-link :to="item.url">
              <img :src="item.image_url" :alt="item.title" />
              </router-link>
            </div>
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

        <div class="mt-3 justify-content-center d-flex text-center">
          <pagination v-model="page" :records="totalRows" :per-page="perPage" @paginate="getItems" :options="{chunksNavigation:false}"/>
        </div>


       </div>
    </div>
</template>

<script>


export default {
    name: "BlogPage",

    data() {
      return {
        Items: null,
        loading:false,
        page:1,
        perPage: 24,
        totalRows:100,
      }
    },
    mounted() {
      this.getItems();
    },

    methods: {
      getItems() {
        let self = this;
        self.Items = null;
        axios.get('/api/blog?page=' + (parseInt(self.page) - 1)).then(function (res) {
          self.Items = res.data.results;
          self.totalRows = res.data.total;
        })
      },
    }

}
</script>
