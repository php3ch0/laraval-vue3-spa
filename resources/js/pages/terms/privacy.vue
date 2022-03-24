<template>
    <div id="AboutPage">


      <div class="container pt-3 pb-3">


      <widget name="PrivacyText" />


      </div>
    </div>

</template>

<script>

export default {
    name:'privacy',

  layout: 'default',

  metaInfo () {
    let self = this;
    return {

      title: window.config.appName+' | Privacy Policy',
      meta: [
        {name: 'description',content: window.config.appName+' Privacy Policy and legal information'},
      ]
    }
  }
}
</script>
