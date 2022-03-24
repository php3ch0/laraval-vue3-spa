<template>

  <footer id="Footer">
  <div class="footer">
    <div class="container">
      <div class="row">
        <div class="col-12 d-none d-lg-block col-lg-auto align-self-center">
          <div class="footer-logo pe-3 text-center text-md-start">
            <a href="/">
              <h2>Logo</h2>
            </a>
          </div>
        </div>
        <div class="col-12 col-lg align-self-center">
          <div class="row">
            <div class="col-12 col-lg-auto col-xl d-block d-xl-block">
              <div class="footer-links text-center text-md-start">
                <h4>Pages</h4>
                <ul>
                  <li><router-link to="/about">About Us</router-link></li>
                  <li><router-link to="/services">Services</router-link></li>
                  <li><router-link to="/galleries">Galleries</router-link></li>
                  <li><router-link to="/blog">News</router-link></li>

                </ul>
              </div>
            </div>
            <div class="col-12 col-lg-auto col-xl d-xl-block">
              <div class="footer-links text-center text-md-start">
                <h4>Legal Info</h4>
                <ul>
                  <li><router-link to="/terms">Terms</router-link></li>
                  <li><router-link to="/privacy">Privacy</router-link></li>
                  <li><router-link to="/cookies">Cookies</router-link></li>
                  <li><router-link to="/contact">Contact Us</router-link></li>
                </ul>
              </div>
            </div>
            <div class="col-12 col-lg">
              <div class="footer-links text-center text-md-start">
                <h4>Contact Us</h4>
                <div class="row footer-contact">
                  <div class="col-12 col-md-auto"><i class="fas fa-map-marker-alt fa-fw"></i></div>
                  <div class="col-12 col-md">Address1,
                    Address2,
                    Town,
                    Postcode</div>
                </div>
                <div class="row footer-contact">
                  <div class="col-12 col-md-auto"><i class="fas fa-phone fa-fw"></i></div>
                  <div class="col"><a href="tel:0000">0000</a></div>
                </div>

                <div class="row footer-contact">
                  <div class="col-12 col-md-auto"><i class="far fa-envelope fa-fw"></i></div>
                  <div class="col-12 col-md"><a href="mailto:info@website.co.uk">info@website.co.uk</a></div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>





    </div>
  </div>
    <div class="copyright text-center pt-3 pb-3">
      <small>© 2022 App Name. All rights Reserved</small>
    </div>


  </footer>

</template>

<script>
export default {
  name: "Footer"
}
</script>
