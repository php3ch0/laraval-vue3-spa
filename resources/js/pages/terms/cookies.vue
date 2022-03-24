<template>
  <div id="AboutPage">


    <div class="container pt-3 pb-3">


      <widget name="CookiesText" />


    </div>
  </div>

</template>

<script>


export default {
  name:'terms.cookies',
  components: {HeaderImageChevron},
  layout: 'default',

  metaInfo () {
    let self = this;
    return {

      title: window.config.appName+' | Cookie Policy',
      meta: [
        {name: 'description',content: 'Terms and Conditions for '+window.config.appName+' and your use of this web site'},
      ]
    }
  }
}
</script>
