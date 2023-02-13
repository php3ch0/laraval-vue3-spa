<template>
  <div id="HomePage">

    <teleport to="head">
      <title>Portside Film and Media Recruitment</title>
      <meta name="description" content="Portside Film & Media Recruitment Ltd is organised to provide clients, candidates and freelancers with an industry-leading service dedicated to all sectors within the industry. We have an in-depth of knowledge of the film, media and recruitment sectors. " />
    </teleport>

    <div class="page-bg">
      <video autoplay muted loop>
        <source src="/storage/videos/homevideo_compressed.mp4" type="video/mp4" />
      </video>
      <div class="container lg:self-center">
        <div class="home-logo py-4 drop-in">
          <img src="/storage/images/logo_border.png" alt="Portside Film and Media Recruitment" />
        </div>
        <div class="home-text py-4 fade-in-delay">
          <h1>A specialist recruitment agency dedicated to all sectors of the film and media industry</h1>
        </div>
        <div class="home-button py-4 text-center fade-in-delay2">
          <router-link to="/register" class="btn btn-primary btn-lg">Register To Join Us</router-link>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
export default {

}
</script>
<style lang="scss" scoped>
  .drop-in {
    -webkit-animation: puff-in-bottom 0.7s cubic-bezier(0.470, 0.000, 0.745, 0.715) both;
    animation: puff-in-bottom 0.7s cubic-bezier(0.470, 0.000, 0.745, 0.715) both;
  }
  .fade-in-delay {
    -webkit-animation: text-focus-in 1s cubic-bezier(0.550, 0.085, 0.680, 0.530) both;
    animation: text-focus-in 1s cubic-bezier(0.550, 0.085, 0.680, 0.530) both;
    animation-delay: 2s;
  }
  .fade-in-delay2 {
    -webkit-animation: text-focus-in 1s cubic-bezier(0.550, 0.085, 0.680, 0.530) both;
    animation: text-focus-in 1s cubic-bezier(0.550, 0.085, 0.680, 0.530) both;
    animation-delay: 4s;
  }
  @-webkit-keyframes puff-in-bottom {
    0% {
      -webkit-transform: scale(2);
      transform: scale(2);
      -webkit-transform-origin: 50% 100%;
      transform-origin: 50% 100%;
      -webkit-filter: blur(4px);
      filter: blur(4px);
      opacity: 0;
    }
    100% {
      -webkit-transform: scale(1);
      transform: scale(1);
      -webkit-transform-origin: 50% 100%;
      transform-origin: 50% 100%;
      -webkit-filter: blur(0px);
      filter: blur(0px);
      opacity: 1;
    }
  }
  @keyframes puff-in-bottom {
    0% {
      -webkit-transform: scale(2);
      transform: scale(2);
      -webkit-transform-origin: 50% 100%;
      transform-origin: 50% 100%;
      -webkit-filter: blur(4px);
      filter: blur(4px);
      opacity: 0;
    }
    100% {
      -webkit-transform: scale(1);
      transform: scale(1);
      -webkit-transform-origin: 50% 100%;
      transform-origin: 50% 100%;
      -webkit-filter: blur(0px);
      filter: blur(0px);
      opacity: 1;
    }
  }
  @-webkit-keyframes text-focus-in {
    0% {
      -webkit-filter: blur(12px);
      filter: blur(12px);
      opacity: 0;
    }
    100% {
      -webkit-filter: blur(0px);
      filter: blur(0px);
      opacity: 1;
    }
  }
  @keyframes text-focus-in {
    0% {
      -webkit-filter: blur(12px);
      filter: blur(12px);
      opacity: 0;
    }
    100% {
      -webkit-filter: blur(0px);
      filter: blur(0px);
      opacity: 1;
    }
  }


</style>
