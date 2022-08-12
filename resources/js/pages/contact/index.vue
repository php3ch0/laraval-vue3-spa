<template>

  <div id="ContactPage">
    <HeaderImage title="Contact Us" subtitle="Contact information for Folkestone Invicta Youth" imageurl="/storage/images/headers/ground2.jpg" />
    <div class="container mx-auto pt-4 pb-4">


      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="white-box">
          <Widget name="ContactPage1" />


          <div class="pt-3 pb-3">
            <div class="flex">
              <div style="width:40px;">
                <i class="fa-solid fa-at fa-2x fa-fw"></i>
              </div>
              <div class="ml-2 text-2xl">
                <a href="mailto:Folkestoneinvictayouth@outlook.com">Folkestoneinvictayouth@outlook.com</a>
              </div>
            </div>
          </div>

          <div class="pt-3 pb-3">
            <div class="flex">
              <div style="width:40px;">
                <i class="fa-solid fa-envelope fa-2x fa-fw"></i>
              </div>
              <div class="ml-2">
                <p>Folkestone Invicta Football Club<br>
                  Cheriton Road Sports Ground<br>
                  Cheriton Road<br>
                  Folkestone, Kent<br>
                  CT19 5JU
                </p>
              </div>
            </div>
          </div>

          <div class="pt-3 pb-3">
            <Widget name="ContactPage2" />
          </div>

        </div>
        <div>

          <Card title="Contact Us By Email">


            <Loading v-if="loading" />

            <template v-else>
              <div v-if="complete" class="mb-3 p-4 bg-green-500 text-white rounded">Your message was sent successfully</div>

              <form @submit.prevent="contactSubmit">
                <div class="mb-2">
                  <label class="block mb-2 text-grey-800 uppercase">Name:</label>
                  <input v-model="form.name" class="block w-full" type="text" />
                  <div class="text-red-500" v-if="formErrors.name" v-text="formErrors.name[0]" />
                </div>

                <div class="mb-2">
                  <label class="block mb-2 text-grey-800 uppercase">Telephone:</label>
                  <input v-model="form.telephone" class="block w-full" type="text" />
                  <div class="text-red-500" v-if="formErrors.telephone" v-text="formErrors.telephone[0]" />
                </div>

                <div class="mb-2">
                  <label class="block mb-2 text-grey-800 uppercase">Email:</label>
                  <input v-model="form.email" class="block w-full" type="email" />
                  <div class="text-red-500" v-if="formErrors.email" v-text="formErrors.email[0]" />
                </div>

                <div class="mb-4">
                  <label class="block mb-2 text-grey-800 uppercase">Message:</label>
                  <textarea v-model="form.message" class="block w-full" style="height:150px" />
                  <div class="text-red-500" v-if="formErrors.message" v-text="formErrors.message[0]" />
                </div>

                <button type="submit" class="btn">Send Message</button>
              </form>
            </template>
          </Card>



        </div>
      </div>


    </div>
  </div>



</template>

<script >

import Card from "../../components/Card";
export default {
  name: "ContactPage",
  components: {Card},
  data: () => {
    return {
        form:{},
        formErrors:{},
        loading:false,
        complete:false,
    }
  },
  methods: {
    contactSubmit() {
      let self=this;
      self.formErrors={};
      self.loading=true;
      self.complete=false;
      axios.post('/api/contact',self.form).then(function(res) {
        self.form={};
        self.loading=false;
        self.complete=true;
        setTimeout(function() {
          self.complete = false;
        },3000)
      }).catch(e=> {
        self.loading=false;
        self.formErrors=e.response.data;
      });
    }
  }
}
</script>
