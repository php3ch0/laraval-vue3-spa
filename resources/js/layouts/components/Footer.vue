<template>
  <footer id="PageFooter">

    <div id="footer1" class="py-5">
      <div class="container p-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
          <div class="text-center">
            <h4>Opening Times</h4>
            <div class="star"><i class="fa-solid fa-star-of-life"></i></div>
            <div>
              <table class="table-none">
                <tr>
                  <td>Sunday:</td>
                  <td>12pm - 8pm</td>
                </tr>
                <tr>
                  <td>Monday:</td>
                  <td>3pm - 9pm</td>
                </tr>
                <tr>
                  <td>Tuesday:</td>
                  <td>3pm - 9pm</td>
                </tr>
                <tr>
                  <td>Wednesday:</td>
                  <td>3pm - 9pm</td>
                </tr>
                <tr>
                  <td>Thursday:</td>
                  <td>3pm - 9pm</td>
                </tr>
                <tr>
                  <td>Friday:</td>
                  <td>12pm - 11pm</td>
                </tr>
                <tr>
                  <td>Saturday:</td>
                  <td>12pm - 11pm</td>
                </tr>
              </table>
            </div>

          </div>

          <div class="justify-center items-center text-center self-center">
            <img src="/storage/images/logo_white.png" alt="The Whichcote Arms" class="footer-logo mx-auto" />
            <h5>The Whichcote Arms</h5>
          </div>

          <div class="text-center">

            <h4>Contact Us</h4>
            <div class="star"><i class="fa-solid fa-star-of-life"></i></div>
            <div>
              <p>The Whichcote Arms,<br>London Rd,
                Osbournby,<br>
                NG34 0DG</p>
              <p>T: <a href="tel:01529 455295">01529 455295</a></p>
              <p>E: <a href="mailto:hello@whichcotearms.co.uk">hello@whichcotearms.co.uk</a></p>
            </div>

          </div>

        </div>
      </div>
    </div>

    <div id="footer2" class="py-4">
      <div class="container flex justify-center">

        <div class="">
          <div class="totop">
            <a href="#" @click.prevent="goToTop"><i class="fa-solid fa-chevron-up 3x"></i></a>
          </div>

          <div class="flex justify-center">
            <ul class="legal-links flex justify-center">
              <li><router-link to="/legal/terms">Terms</router-link></li>
              <li><router-link to="/legal/privacy">Privacy</router-link></li>
              <li><router-link to="/contact">Contact</router-link></li>
            </ul>
          </div>
        </div>



      </div>
    </div>




  </footer>
</template>

<script>
export default {
  name: "PageFooter",
  methods: {
    goToTop() {
      window.scrollTo({
        top: 0,
        behavior: 'smooth',
      })
    }
  }
}
</script>
