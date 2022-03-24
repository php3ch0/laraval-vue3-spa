<template>
  <div id="BlogView">


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




  export default {
    layout: 'default',
    name:'BlogView',

    data() {
      return {
        thisItem: {
            title:window.config.appName+' | News Blog',
            article:'Read more about the latest news and information from App Name',
            seo:{ title: window.config.appName+' | News Blog and Information',}
        },

      }
    },
      metaInfo () {
          let self = this;
          return {

              title: window.config.appName+' | '+ self.thisItem.title,
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
