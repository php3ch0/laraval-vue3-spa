<template>
  <div id="HeaderImage" class="flex relative" ref="header-wrap">

    <div class="header-image" >
      <img :src="imageurl" :alt="title" ref="header-bg" />
    </div>

    <div v-if="widget" class="widget-header container mx-auto self-center">
        <div class="self-center">
          <Widget :name="widget" />
        </div>
    </div>

    <div v-else class="widget-header container w-auto flex justify-center self-center">
        <div class="text-center self-center w-auto">
          <h1 class="cursive animate__animated animate__fadeInUp animate__delay-1s" v-if="title">{{ title }}</h1>
          <div class="separator flex animate__animated animate__fadeInUp animate__delay-1s">
            <div class="left flex-auto self-center"></div>
            <div class="star flex-none"><i class="fa-solid fa-star-of-life"></i></div>
            <div class="right flex-auto self-center"></div>
          </div>
          <h4 class="animate__animated animate__fadeInUp animate__delay-3s" v-if="subtitle">{{ subtitle }}</h4>
        </div>
      </div>
  </div>
</template>

<script>
export default {
    name: "HeaderImage",
    props: {
        title:String,
        subtitle:String,
        imageurl:String,
        widget:String
    },
    created () {
      window.addEventListener('scroll', this.parralaxScroll);
    },
    unmounted () {
      window.removeEventListener('scroll', this.parralaxScroll);
    },
    methods: {
      parralaxScroll (event) {
        let self=this;
        let img = self.$refs['header-bg'];
        let headerwrap=self.$refs['header-wrap'];

        const speed = 1;
        let pos = (window.pageYOffset / speed);

        if((img.height-pos) > headerwrap.clientHeight) {
          //console.log((img.height-pos)+ ' '+ headerwrap.clientHeight);
          img.style.marginTop = '-'+pos+'px';
        }

      }
    }
}
</script>
