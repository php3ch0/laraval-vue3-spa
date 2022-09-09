<template>
    <div id="AboutPage">

      <teleport to="head">
        <title>Peter Kifodu Foundation | About The Peter Kifodu Foundation</title>
        <meta name="description" content="Information about the Peter Kifodu Foundation, how we work, who we support and what we do to promote health, well-being and prosperity" />
      </teleport>

      <HeaderImage widget="abouttitle" title="About the Peter Kifodu Foundation" imageurl="/storage/images/headers/about.webp" />


      <div class="container">
           <div class="mb-4 mt-4 text-center">
              <Widget name="AboutText1" />
           </div>
           <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
               <div class="white-box">
                 <Widget name="AboutText2" />
               </div>
               <div class="white-box">
                 <Widget name="AboutText3" />
               </div>
           </div>
       </div>
    </div>
</template>

<script>


export default {
    name: "AboutPage",

}
</script>
