<template>
  <div id="BlogView">

    <teleport to="head">
      <title>{{ seo.title }}</title>
      <meta name="description" :content="seo.description" />
      <meta name="og:title" :content="seo.title" />
      <meta name="og:description" :content="seo.description" />
      <meta v-if="seo.image" name="og:image" :content="seo.image" />
      <meta v-if="seo.url" name="og:title" :content="seo.url" />
    </teleport>

    <HeaderImage :title="thisItem.title" :subtitle="'Published on: '+thisItem.published" :imageurl="thisItem.image_url" />

    <div v-if="thisItem" class="pt-4">
        <div class="container">

          <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
              <div class="bg-white text-left blog-article">
                <article class="text-body">
                  <div v-html="thisItem.article_html"></div>
                </article>
              </div>
            </div>
          </div>

          <div v-if="thisItem.images && thisItem.images.length>0" class="mt-4 mb-4 pt-4 pb-4">
            <hr class="pb-4 mb-4">
            <BlogGallerySlide :id="thisItem.id" />

          </div>

          <hr class="pt-4 mt-4">

          <div class="text-center mt-3 mb-3">
            <router-link to="/blog" class="btn btn-primary mr-2 mb-3"><i class="fa fa-chevron-left"></i> Go Back</router-link>
          </div>
      </div>
    </div>



  </div>

</template>

<script>

import BlogGallerySlide from "./components/BlogGallerySlide";

  export default {

    layout: 'default',
    name:'BlogView',

    components : {
      BlogGallerySlide
    },

    data() {
      return {
        thisItem:{},
        seo: {
          title: "Peter Kifodu Foundation | News Blog",
          description:"News from the Peter Kifodu Foundation",
          image:null,
          url:null,
        }
      }
    },

    mounted() {
        let self = this;
        axios.get('/api/blog/' + self.$route.params.slug).then(function (res) {
            self.thisItem = res.data;
            self.thisItem.published=new Date(self.thisItem.created_at).toLocaleDateString();
            self.seo.title = res.data.title;
            self.seo.description = res.data.preview_text;
            self.seo.image=window.config.appURL+res.data.image_url;
            self.seo.url=window.config.appURL+res.data.url;
        }).catch((err) => {
            console.log(err.response);
            this.$router.push({name: '404'})
        })
    }
  }

</script>
