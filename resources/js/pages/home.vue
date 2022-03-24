<template>
  <div id="HomePage">
    <div class="container mt-3 mb-3">
      <div class="text-center">
        <Widget name="HomeText" />
      </div>

    </div>
  </div>
</template>

<script>


export default {

  layout:'default',

  data: () => ({

  }),

  metaInfo () {
    return {

      title: window.config.appName+' | App Name',
      meta: [
        {name: 'description',content: ''},
      ]
    }
  }

}
</script>
