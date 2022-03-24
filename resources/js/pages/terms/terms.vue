<template>
  <div id="AboutPage">


    <div class="container pt-3 pb-3">


      <widget name="TermsText" />


    </div>
  </div>

</template>

<script>



export default {
  name:'terms',

  layout: 'default',

  metaInfo () {
    return {

      title: window.config.appName+' | Terms and Conditions',
      meta: [
        {name: 'description',content: 'Terms and Conditions for '+window.config.appName+' and your use of this web site'},
      ]
    }
  }
}
</script>
