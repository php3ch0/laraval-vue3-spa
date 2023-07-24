<template>
  <div id="HomePage">

    <teleport to="head">
      <title>The Whichcote Arms</title>
      <meta name="description" content="The Whichcote Arms in Osbournby offers great food at our restaurant or pop in for a coffee in our cafe. We also have live events, a beer garden and farm shop on premises." />
    </teleport>

    <HeaderImage title="Welcome" subtitle="To The Whichcote Arms" imageurl="/storage/images/headers/home.jpg" />


  <div class="container">

    <div class="my-5 grid grid-cols-1 lg:grid-cols-2 gap-4 items-center">
      <div class="header-text-cursive self-center">
      <div class="invisible" v-observe-visibility="{callback:(isVisible, entry) => addAnimate(isVisible, entry, ['animate__animated','animate__fadeInLeft','animate__delay-0-5s']),throttle: 300}">
       <Widget name="HomeText1" />
      </div>


      </div>
      <div class="self-center">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:cols-1 xl:cols-2 gap-4 home-image-grid">
          <div class="invisible" v-observe-visibility="{callback:(isVisible, entry) => addAnimate(isVisible, entry, ['animate__animated','animate__fadeInRight','animate__delay-0-5s']),throttle: 300}">
            <Widget name="HomeImage1" class="img-home" />
          </div>
          <div class="invisible" v-observe-visibility="{callback:(isVisible, entry) => addAnimate(isVisible, entry, ['animate__animated','animate__fadeInRight','animate__delay-1s']),throttle: 300}">
            <Widget name="HomeImage2" class="img-home" />
          </div>
        </div>
      </div>
    </div>

  </div>

  <Testimonials />

    <div class="container" style="margin:45px auto;">
      <div class="pt-4 pb-4 text-center">
        <Widget name="HomeTextBottom" />
      </div>
    </div>

  <div class="container header-text-cursive">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 my-5">
      <div class="item invisible" v-observe-visibility="{callback:(isVisible, entry) => addAnimate(isVisible, entry, ['animate__animated','animate__fadeInUp','animate__delay-0s']),throttle: 300}">
        <div class="item-image">
          <Widget name="HomeItem1Image" />
        </div>
        <div class="item-text">
          <Widget name="HomeItem1Text" />

        </div>
        <div class="item-link">
          <router-link to="/restaurant">Find Out More >></router-link>
        </div>
      </div>
      <div class="item invisible" v-observe-visibility="{callback:(isVisible, entry) => addAnimate(isVisible, entry, ['animate__animated','animate__fadeInUp','animate__delay-0-5s']),throttle: 300}">
        <div class="item-image">
          <Widget name="HomeItem2Image" />
        </div>
        <div class="item-text">
          <Widget name="HomeItem2Text" />
        </div>
        <div class="item-link">
          <router-link to="/rooms">Find Out More >></router-link>
        </div>
      </div>
      <div class="inline md:hidden lg:inline">
        <div class="item invisible" v-observe-visibility="{callback:(isVisible, entry) => addAnimate(isVisible, entry, ['animate__animated','animate__fadeInUp','animate__delay-1s']),throttle: 300}">
        <div class="item-image">
          <Widget name="HomeItem3Image" />
        </div>
        <div class="item-text">
          <Widget name="HomeItem3Text" />
        </div>
        <div class="item-link">
          <router-link to="/farmshop">Find Out More >></router-link>
        </div>
      </div>
      </div>
      </div>
  </div>



  </div>

</template>

<script>
import HeaderImage from "../components/HeaderImage.vue";
import Testimonials from "../components/Testimonials.vue";

export default {
  components: {Testimonials, HeaderImage},
  methods: {
    addAnimate(isVisible,item,classes) {
      if(isVisible){
        item.target.classList.remove('invisible');
        for(let c of classes) {
          item.target.classList.add(c);
        }
      }


    }
  }

}
</script>
