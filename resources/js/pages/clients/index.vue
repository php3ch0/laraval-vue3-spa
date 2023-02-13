<template>
  <div id="ClientsPage">

    <teleport to="head">
      <title>Portside Film and Media Recruitment | Clients</title>
      <meta name="description" content="For production companies, post production companies, broadcasters and agencies, studios and all ancillary service, we offer recruitment solutions" />
    </teleport>

    <HeaderImage widget="clientstitle" title="Portside Recruitment Clients" imageurl="/storage/images/headers/clients.jpg" />


    <div class="container">
      <div class="mb-4 mt-4 text-center">
        <Widget name="ClientsText1" />
      </div>

      <div class="my-4 text-center grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="client-item">
          <div class="image">
            <Widget name="ClientItem1Image" />
          </div>
          <div class="text">
            <Widget name="ClientItem1Text" />
          </div>
        </div>

        <div class="client-item">
          <div class="image">
            <Widget name="ClientItem2Image" />
          </div>
          <div class="text">
            <Widget name="ClientItem2Text" />
          </div>
        </div>

        <div class="client-item">
          <div class="image">
            <Widget name="ClientItem3Image" />
          </div>
          <div class="text">
            <Widget name="ClientItem3Text" />
          </div>
        </div>

        <div class="client-item">
          <div class="image">
            <Widget name="ClientItem4Image" />
          </div>
          <div class="text">
            <Widget name="ClientItem4Text" />
          </div>
        </div>

      </div>

    </div>
  </div>



  <div class="container text-center my-4">
    <Widget name="ClientsText2" />
  </div>

  <div class="container text-center">
    <router-link to="/contact" class="btn btn-lg btn-primary"  style="margin:80px 0;">Get In Contact</router-link>
  </div>


</template>

<script>



export default {
  name: "ClientsPage",

}
</script>
