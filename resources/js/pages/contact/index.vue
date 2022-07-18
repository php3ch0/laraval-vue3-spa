<template>

    <div class="container mx-auto pt-4 pb-4">


        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <h1>Contact Shepway Computers</h1>
                <p>Please feel free to contact one of the team about any IT support or computer enquiries you may have using the contact information below or by using our online contact form.</p>

                <div class="pt-3 pb-3">
                    <div class="flex">
                        <div style="width:40px;">
                            <i class="fa-solid fa-square-phone fa-2x fa-fw"></i>
                        </div>
                        <div class="ml-2 text-2xl">
                          <a href="tel:01303720019">01303 720 019</a>
                        </div>
                    </div>
                </div>

                <div class="pt-3 pb-3">
                  <div class="flex">
                    <div style="width:40px;">
                      <i class="fa-solid fa-at fa-2x fa-fw"></i>
                    </div>
                    <div class="ml-2 text-2xl">
                      <a href="mailto:support@shepwaycomputers.co.uk">support@shepwaycomputers.co.uk</a>
                    </div>
                  </div>
                </div>

                <div class="pt-3 pb-3">
                    <div class="flex">
                        <div style="width:40px;">
                            <i class="fa-solid fa-envelope fa-2x fa-fw"></i>
                        </div>
                        <div class="ml-2">
                            <p>Shepway Computers<br>
                                4 Major Close<br>
                          (Off Pond Hill Road)<br>
                          Folkestone<br>
                          Kent<br>
                          CT20 5RW</p>
                        </div>
                    </div>
                </div>

                <div class="pt-3 pb-3">
                  <h4>Office Opening Hours</h4>
                  <p>Mon-Friday 9am-5pm</p>
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

      <hr class="mt-4 mb-4">

      <div class="mt-4 mb-4 text-center">
        <h2>How To Find Shepway Computers</h2>
      </div>
      <div class="mt-4 mb-4">
        <img src="/storage/images/photos/map.png" alt="Direction Map To Shepway Computers Folkestone" class="mx-auto max-w-[800px]" />
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
