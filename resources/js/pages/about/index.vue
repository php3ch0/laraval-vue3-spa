<template>
    <div id="AboutPage">


      <div class="container pt-4 pb-4">

        <div class="row">
          <div class="col-12 col-lg-8 align-self-center">
            <Widget name="AboutText" />
          </div>
          <div class="col-12 col-lg-4 align-self-center">
            <Widget name="AboutPhoto" />
          </div>
        </div>



      </div>
    </div>

</template>

<script>



export default {
    name:'about',

  layout: 'default',

  metaInfo () {
    return {

      title: window.config.appName+' | About Us',
      meta: [
        {name: 'description',content: ''},
      ]
    }
  }
}
</script>
