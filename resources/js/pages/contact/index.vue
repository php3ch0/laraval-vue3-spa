<template>
  <div id="ContactPage">


    <div class="container mt-3 mb-3 pt-3 pb-3">

      <div class="text-center">
        <h2>Get In Touch</h2>
        <div class="line"></div>
        <h4>Please feel free to contact one of the team on the telephone or via email using the form below.</h4>
      </div>

      <div class="mt-3 mb-3">
        <form @submit.prevent="sendContact">

          <LoadingSm v-if="loading" />
          <template v-else>


        <div class="row align-items-stretch">
          <div class="col-12 col-lg-6">
            <div class="p-2">
              <div class="mb-2">
                <input v-model="contact.company_name" class="form-control" type="text" placeholder="* Company Name" />
                <span v-if="errors.company_name" class="error">{{ errors.company_name[0] }}</span>
              </div>
              <div class="mb-2">
                <input v-model="contact.contact_name" class="form-control" type="text" placeholder="* Contact Name" />
                <span v-if="errors.contact_name" class="error">{{ errors.contact_name[0] }}</span>
              </div>
              <div class="mb-2">
                <input v-model="contact.email" class="form-control" type="email" placeholder="* Email Address" />
                <span v-if="errors.email" class="error">{{ errors.email[0] }}</span>
              </div>
              <div class="mb-2">
                <input v-model="contact.phone" class="form-control" type="text" placeholder="* Contact Phone" />
                <span v-if="errors.phone" class="error">{{ errors.phone[0] }}</span>
              </div>
            </div>


          </div>
          <div class="col-12 col-lg-6">
            <div class="p-2">
              <div class="mb-2">
                <textarea v-model="contact.message" class="form-control" style="height:100%; min-height:216px;" placeholder="* Message" />
                <span v-if="errors.message" class="error">{{ errors.message[0] }}</span>
              </div>
            </div>

          </div>
        </div>

        <div class="text-center mt-3 mb-3">
          <button type="submit" class="btn btn-primary btn-sq">Send Message</button>
        </div>

          </template>

        </form>
      </div>

     </div>


    <div class="container mt-3 mb-3">
      <hr>
      <div class="row mt-3 mb-3">
        <div class="col-12 col-lg text-center text-lg-start">
          <h4>Telephone / Email</h4>

          <div class="row contact-row">
            <div class="col-auto"><i class="fas fa-phone fa-fw"></i></div>
            <div class="col"><a href="tel:0000">0000</a></div>
          </div>

          <div class="row contact-row">
            <div class="col-auto"><i class="far fa-envelope fa-fw"></i></div>
            <div class="col"><a href="mailto:info@website.co.uk">info@website.co.uk</a></div>
          </div>

        </div>
        <div class="col-12 col-lg text-center text-lg-end">
          <h4>Write To Us</h4>

          <div class="contact-address">
            <p>Address1<br />
              Address2<br />
              Town, Postcode</p>
          </div>
        </div>
      </div>
    </div>


  </div>
</template>

<script>

import LoadingSm from "../../components/LoadingSm";
export default {
  components: {LoadingSm},

  metaInfo () {
    return {
      title: window.config.appName+' | Contact Us',
      meta: [
        {name: 'description',content: 'Contact App Name to discuss your next project.'},
      ]
    }
  },

  data() {
    return {
      contact:{},
      errors:{},
      loading:false,
      complete:false,
    }},
  methods: {
    sendContact() {
      let self=this;
      self.errors={};
      self.loading=true;
      self.$axios.post('/api/contact',self.contact).then(function(res) {
        self.loading=false;
        self.contact={};
        self.complete=true;
        setTimeout(function() {
          self.complete=false;
        },3000);
      }).catch(e=> {
        self.loading=false;
        self.errors = e.response.data;
      });
    }
  }
}
</script>
