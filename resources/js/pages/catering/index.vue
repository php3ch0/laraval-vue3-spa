<template>
    <div id="CateringPage">

      <teleport to="head">
        <title>The Picnic Hut | Event Catering in Kent</title>
        <meta name="description" content="The Picnic Hut are pleased to offer extensive catering, and mobile catering services from our base in New Romney across the Kent region including Ashford, Folkestone, Hythe and Canterbury." />
      </teleport>

      <HeaderImage widget="cateringtitle" title="Event Catering Services in New Romney, Hythe, Folkestone and Ashford, Kent" imageurl="/storage/images/headers/event-catering.jpg" />
      <div class="container mx-auto pt-6 pb-6">

        <div class="grid grid-cols-12 gap-4 py-8">
          <div class="col-span-12 lg:col-span-4 mb-3 self-center">
            <Widget name="cateringimage" class="w-full" />
          </div>
          <div class="col-span-12 lg:col-span-8 mb-3 self-center">
            <Widget name="cateringtext" />
            <router-link to="/contact" class="btn btn-primary mt-3 mb-3">Enquire Now</router-link>
          </div>
        </div>

        <hr />

        <div class="my-10">
          <GallerySlide :id="2" />
        </div>


      </div>
    </div>
</template>

<script>


import GallerySlide from "../../components/GallerySlide";
export default {
    name: "CateringPage",
  components: {GallerySlide},
}
</script>
