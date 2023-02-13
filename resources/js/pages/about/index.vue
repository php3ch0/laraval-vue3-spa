<template>
  <div id="AboutPage">

    <teleport to="head">
      <title>Portside Film and Media Recruitment | About Us</title>
      <meta name="description" content="Portside Film & Media Recruitment Ltd is organised to provide clients, candidates and freelancers with an industry-leading service dedicated to all sectors within the industry. " />
    </teleport>

    <HeaderImage widget="abouttitle" title="About Portside Recruitment" imageurl="/storage/images/headers/about.jpg" />


    <div class="container">
      <div class="mb-4 mt-4 text-center">
        <Widget name="AboutText1" />
      </div>

    </div>
  </div>

  <div class="container text-center">
    <h2>Companies and Sponsors We Work With</h2>
  </div>

  <div class="container">
    <GallerySlide :id="1" />
  </div>
</template>

<script>


import GallerySlide from "../../components/GallerySlide";
export default {
  name: "AboutPage",
  components: {GallerySlide},
}
</script>
