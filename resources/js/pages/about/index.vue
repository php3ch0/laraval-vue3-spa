<template>
    <div id="AboutPage">

      <HeaderImageChevron image="about.jpg" title="About Penshurst Planning" />

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
    let self = this;
    return {

      title: window.config.appName+' | About Us',
      meta: [
        {name: 'description',content: 'Penshurst Planning is a Chartered Town Planning and Development consultancy based near Rochester in Kent, and provides a comprehensive range of planning and related services to its clients, which include developers, land owners, small businesses and private individuals.'},
      ]
    }
  }
}
</script>
