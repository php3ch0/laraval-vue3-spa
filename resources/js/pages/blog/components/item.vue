<template>
  <div id="news-item" class="blog-item">
    <div v-if="loading" class="loading">
      <img src="/storage/images/loaders/loading.svg" alt="Loading" title="Loading">
      <small>Loading...</small>
    </div>
    <div v-else>
      <router-link :to="thisItem.url">
        <div class="item-image">
          <img v-if="thisItem.image_url" :src="thisItem.image_url" :alt="thisItem.name"  />
          <div v-else class="text-center">
            <img src="/storage/images/loaders/loading.svg" alt="Loading" class="loading-img" :alt="thisItem.title" :title="thisItem.title"/>
            <div class="mt-2">Loading...</div>
          </div>
        </div>
        <div class="item-name">
          <div class="date">Published: {{ thisItem.published }}</div>
          <div class="title"><h3>{{ thisItem.title}}</h3></div>
          <div class="preview"> {{ thisItem.preview_text }}</div>

        </div>
      </router-link>
    </div>

    </div>

</template>

<script>
    export default {
        name: "BlogItem",
        data() {
            return {
                thisItem: {
                    id: null,
                    title: null,
                },
                loading:true,
        }},
        props: {
            id: Number,
        },
        mounted() {
            let self=this;
            self.$axios.get('/api/blog/'+self.id).then(function (res) {
                self.thisItem = res.data;
                self.loading=false;
            })
        },

    }
</script>
