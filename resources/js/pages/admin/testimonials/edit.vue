<template>
    <div id="TestimonialsEdit" class="container-fluid">
      <div class="row">
        <div class="col-6">
          <h1>Manage Testimonials</h1>
        </div>

        <div class="col-12 col-lg-6 text-end">
          <router-link to="/admin/testimonials" class="btn btn-primary">Go Back</router-link>
        </div>

      </div>

      <form @submit.prevent="editItem">
        <card v-if="testimonial" title="Edit testimonial" class="mt-3">

              <div v-if="ErrorMessages" class="alert alert-danger mb-3">
                <div v-for="Error in ErrorMessages">
                  {{ Error[0] }}
                </div>
              </div>
              <div class="mb-2">
                <label>Name</label>
                <input v-model="testimonial.name" class="form-control" />

              </div>
              <div class="mb-2">
                <label>Job Title</label>
                <input v-model="testimonial.job_title" class="form-control" />

              </div>
              <div class="mb-2">
                <label>Company Name</label>
                <input v-model="testimonial.company" class="form-control" />

              </div>
              <div class="mb-2">
                <label>Text</label>
                <textarea v-model="testimonial.text" rows="5" class="form-control"></textarea>
              </div>

              <button type="submit" class="btn btn-primary">Save Changes</button>
              <a class="btn btn-danger ml-2" @click="showDeleteModal" >Delete</a>





        </card>
      </form>



    </div>


</template>

<script>


    export default {
        middleware: 'admin',
        layout: 'admin',
        name:'adminTestimonialsEdit',

        params: {
            id: Number,
        },


        data() {
            return {
                testimonial: {},
                ErrorMessages:null,
            }

        },

        created()  {

               this.getItem()
        },
        methods: {
              getItem() {
                  let self = this;
                  self.$axios.get('/api/testimonials/' + self.$route.params.id).then(function (res) {
                      self.testimonial = res.data;
                  });
              },

            editItem() {
                let self = this;

              let formData = new FormData();

              var arr = self.testimonial;
              for (let key in arr) {
                Array.isArray(arr[key])
                  ? arr[key].forEach(value => formData.append(key + '[]', value))
                  : formData.append(key, arr[key]) ;
              }



              self.$axios.post('/api/testimonials/'+self.testimonial.id,
                formData,
                { headers: {'Content-Type': 'multipart/form-data'}})
                    .then(function (res) {
                       self.$router.push({path: '/admin/testimonials'});
                    }).catch(err => {
                      self.ErrorMessages = err.response.data;
                  });
            },
            showDeleteModal() {
                this.DeleteModal = '';
                let self = this;
                this.$bvModal.msgBoxConfirm('Are you sure you want to delete this?')
                    .then(value => {
                        if(value==true) {
                            self.$axios.delete('/api/testimonials/'+self.testimonial.id)
                                .then(function () {
                                    self.$router.push({path: '/admin/testimonials'});
                                });
                        }
                    })
            },


        }
    }


</script>
