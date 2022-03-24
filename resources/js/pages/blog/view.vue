<template>
  <div id="BlogView">

    <BlogHeaderImage :image="thisItem.image_url" :title="thisItem.title" />


    <div v-if="thisItem" class="pt-4">
        <div class="container">


              <div class="text-left blog-article">
                <article>
                  <div v-html="thisItem.article_html"></div>
                </article>


        </div>

          <div class="text-center mt-3 mb-3">
            <router-link to="/blog" class="btn btn-primary mr-2 mb-3"><i class="fa fa-chevron-left"></i> Go Back</router-link>
          </div>
      </div>
    </div>



  </div>

</template>

<script>

import BlogHeaderImage from "./components/BlogHeaderImage";


  export default {
    layout: 'default',
    name:'BlogView',
    components: { BlogHeaderImage },
    data() {
      return {
        thisItem: {
            title:window.config.appName+' | News Blog',
            article:'Read more about the latest news and information from Penshurst Planning, Town Planning and Development Planning kent and Medway',
            seo:{ title: window.config.appName+' | News Blog and Information',}
        },

      }
    },
      metaInfo () {
          let self = this;
          return {

              title: 'Penshurst Planning | '+ self.thisItem.title,
              meta: [
                  {name: 'description',content: self.thisItem.article.replace(/<[^>]*>?/gm, '').substring(0, 180)+'...'},
                  {name: 'og:title', content: self.thisItem.seo.title },
                  {name: 'og:description', content: self.thisItem.article.replace(/<[^>]*>?/gm, '').substring(0, 180)+'...' },
                  {name: 'og:image', content: self.thisItem.seo.image },
                  {name: 'og:url', content: self.thisItem.seo.url },
              ]
          }
      },

    mounted() {
        let self = this;
        self.$axios.get('/api/blog/' + self.$route.params.slug).then(function (res) {
            self.thisItem = res.data;
        }).catch((err) => {
            console.log(err.response);
            this.$router.push({name: '404'})
        })
    },

  }

</script>
