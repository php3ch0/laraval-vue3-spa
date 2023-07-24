<template>

  <div id="Seperator" class="invisible" v-observe-visibility="{callback:(isVisible, entry) => addAnimate(isVisible, entry, ['animate__animated','animate__fadeInUp']),throttle: 300}">
    <div class="separator flex">
      <div class="left flex-auto self-center"></div>
      <div class="star flex-none"><i class="fa-solid fa-star-of-life"></i></div>
      <div class="right flex-auto self-center"></div>
    </div>
  </div>

</template>

<script>
export default {
  name: "Seperator",
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
