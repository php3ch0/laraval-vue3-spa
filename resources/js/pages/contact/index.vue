<template>

  <div id="ContactPage">

    <teleport to="head">
      <title>Portside Film and Media Recruitment | Contact Us</title>
      <meta name="description" content="Contact us to find out how we can help you with your Film and Media Recruitment needs" />
    </teleport>


    <HeaderImage widget="contacttitle" title="Contact The Portside Film and Media Recruitment" imageurl="/storage/images/headers/contact.jpg" />


    <div class="container">

      <div class="pt-6 pb-6">


      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 content-center">
        <div>
          <Widget name="ContactText1" />


          <div class="pt-3 pb-3">
            <div class="flex">
              <div style="width:40px;">
                <i class="fa-solid fa-at fa-2x fa-fw"></i>
              </div>
              <div class="ml-2 text-2xl">
                <a  style="word-break: break-all;" href="mailto:enquiries@portsiderecruitment.com">enquiries@portsiderecruitment.com</a>
              </div>
            </div>
          </div>

          <div class="pt-3 pb-3">
            <div class="flex">
              <div style="width:40px;">
                <i class="fa-solid fa-envelope fa-2x fa-fw"></i>
              </div>
              <div class="ml-2">
                <p>Portside Recruitment<br>
                  Floor 5/13<br>
                  55 Broadway<br>
                  London<br>
                  SW1H OBH
                </p>
                <p>55 Broadway is immediately above St James’ Park underground station which is on the District & Circle lines, one minute from Victoria Station.</p>
              </div>
            </div>
          </div>


        </div>
        <div>

          <div class="mb-3">
            <h2>Map To Our Offices</h2>
          </div>

          <iframe width="100%" height="350" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=55 Broadway,London&key=AIzaSyA4hrkNkdnsY75n4Y5yP2v2iS66JDwCyWc" allowfullscreen></iframe>




        </div>
      </div>


    </div>
  </div>
  </div>



</template>

<script >


export default {
  name: "ContactPage",

  data: () => {
    return {
        loading:false,
        complete:false,
    }
  },
  methods: {

  }
}
</script>
