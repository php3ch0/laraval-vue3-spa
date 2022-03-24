<template>
  <div id="HomePage">
    <HomeHeader :id="3" />
    <div class="container mt-3 mb-3">
      <div class="text-center">
        <Widget name="HomeText" />
      </div>

    </div>
  </div>
</template>

<script>

import HomeHeader from "../components/HomeHeader";

export default {

  layout:'default',
  components: { HomeHeader },

  data: () => ({



  }),

  metaInfo () {
    return {

      title: window.config.appName+' | Town Planning and Development Planning Services',
      meta: [
        {name: 'description',content: 'Expert town planning and development planning advice from Penshurst Planning for construction and building projects in Kent and Medway '},
      ]
    }
  }

}
</script>
