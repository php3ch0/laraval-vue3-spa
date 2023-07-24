<template>

  <div id="ContactPage">

    <teleport to="head">
      <title>Whichcote Arms | Contact Us</title>
      <meta name="description" content="Contact The Whichcote Arms Osbournby to book a reservation at our restaurant or book a room for your travels" />
    </teleport>


    <HeaderImage title="Get In Touch" subtitle="With The Whichcote Arms" imageurl="/storage/images/headers/contact.jpg" />


    <div class="container">

      <div class="pt-6 pb-6">

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 content-center">
        <div>

          <div class="my-3">
            <h2 class="cursive">Contact Us</h2>
          </div>

          <div class="pt-3 pb-3">

            <div class="flex">
              <div style="width:40px;" class="mr-3">
                <i class="fa-solid fa-at fa-2x fa-fw"></i>
              </div>
              <div class="ml-2 text-2xl">
                <a  style="word-break: break-all;" href="mailto:hello@whichcotearms.co.uk">hello@whichcotearms.co.uk</a>
              </div>
            </div>
          </div>

          <div class="pt-3 pb-3">

            <div class="flex">
              <div style="width:40px;" class="mr-3">
                <i class="fa-solid fa-phone fa-2x fa-fw"></i>
              </div>
              <div class="ml-2 text-2xl">
                <a  style="word-break: break-all;" href="tel:01529 455295">01529 455295</a>
              </div>
            </div>
          </div>

          <div class="pt-3 pb-3">

            <div class="flex">
              <div style="width:40px;" class="mr-3">
                <i class="fa-solid fa-mobile fa-2x fa-fw"></i>
              </div>
              <div class="ml-2 text-2xl">
                <a  style="word-break: break-all;" href="tel:07538682976">07538682976</a>
              </div>
            </div>
          </div>

          <div class="pt-3 pb-3">
            <div class="flex">
              <div style="width:40px;" class="mr-3">
                <i class="fa-solid fa-envelope fa-2x fa-fw"></i>
              </div>
              <div class="ml-2">
                <p>Whichcote Arms<br>
                  London Rd,<br> Osbournby,<br> NG34 0DG
                </p>
              </div>
            </div>
          </div>

          <div class="my-3 mx-auto">
            <div class="socials flex gap-4 justify-left">
              <div class="flex-none">
                <a href="https://m.facebook.com/thewhichcotearms?wtsid=rdr_0ELYzeJg6qoste0dd" target="_blank"><i class="fa-brands fa-facebook fa-2x"></i></a>
              </div>
              <div class="flex-none">
                <a href="https://www.instagram.com/thewhichcotearms/" target="_blank"><i class="fa-brands fa-instagram fa-2x"></i></a>
              </div>
              <div class="flex-none">
                <a href="https://twitter.com/WhichcoteArms" target="_blank"><i class="fa-brands fa-twitter fa-2x"></i></a>
              </div>
            </div>
          </div>


        </div>
        <div>

          <Widget name="ContactImage" class="img-fluid" />








        </div>
      </div>


    </div>
  </div>

    <div class="my-3">
      <iframe width="100%" height="350" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=Whichcote Arms&key=AIzaSyDSabTE6O3kBVpG4PcqUelbelcFKmfHrh4" allowfullscreen></iframe>

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
