<template>

  <div id="AdminEditService">
    <div class="row">
      <div class="col-9">
        <h1>Manage Services</h1>
      </div>
      <div class="col-3 text-end">
          <router-link to="/admin/services" class="btn btn-primary">Go Back</router-link>
      </div>
    </div>



    <div v-if="Service" class="mt-3">
      <card title="Edit A Service">
        <div v-if="ErrorMessages" class="alert alert-danger mb-3">
          <div v-for="Error in ErrorMessages">
            {{ Error }}
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-lg-4">
            <div class="mb-2">
              <label>Please enter a name for this service.</label>
              <input v-model="Service.name" class="form-control" />
            </div>
          </div>
          <div class="col-12 col-lg">
            <div class="mb-2">
              <label>Slug/URL.</label>
              <input v-model="Service.slug" class="form-control" />
            </div>
          </div>

          <div class="col12 col-lg">
            <div v-if="Galleries" class="mb-2">
              <label>Assign A Gallery.</label>
              <select v-model="Service.gallery_id" class="form-control">
                <option value="" :selected="(!Service.gallery_id || false)">None</option>
                <option v-for="g in Galleries" :value="g.id" :selected="(Service.gallery_id===g.id)">{{ g.name }}</option>
              </select>
            </div>
          </div>
        </div>

        <div class="mb-2">
          <label>Please enter a short description.</label>
          <input v-model="Service.short_text" class="form-control" />
        </div>
        <div class="row">
          <div class="col">
            <div class="mb-2">
              <div class="admin-image">
                <img :src="Service.imageheader_url" :alt="Service.name" ref="image_header_image" />
              </div>
              <div class="text-center p-2">
                <i class="fas fa-sync-alt" title="Rotate Image" @click="rotateImage('image_header')"></i>
              </div>
              <label>Header Image</label>
              <input v-on:change="imageUpload('image_header')" name="image_header" type="file" ref="image_header" class="form-control" />
              <small>Leave blank to keep the same image</small>
            </div>

          </div>
          <div class="col">
            <div class="mb-2">
              <div class="admin-image">
                <img :src="Service.imageicon_url" :alt="Service.name" ref="image_icon_image" />
              </div>
              <div class="text-center p-2">
                <i class="fas fa-sync-alt" title="Rotate Image" @click="rotateImage('image_icon')"></i>
              </div>
              <label>Icon Image</label>
              <input v-on:change="imageUpload('image_icon')" name="image_icon" type="file" ref="image_icon" class="form-control" />
              <small>Leave blank to keep the same image</small>
            </div>

          </div>
        </div>

        <div class="mb-2">
          <label>Service Description</label>
          <editor
            api-key="no-api-key"
            :disabled=false
            :init= "initTiny"
            v-model="Service.text"
            :initial-value="Service.text"
            :inline=false
            plugins="code link lists powerpaste image media"
            powerpaste_word_import="clean"
            powerpaste_html_import= "clean"
            powerpaste_clean_filtered_inline_elements="em, b, i, u, strike, sup, sub, font"
            toolbar="formatselect | forecolor | bold italic underline strikethrough removeformat | alignleft aligncenter alignright | bullist numlist blockquote | link unlink | code"
          />

        </div>

        <div class="mb-2">
          <button v-if="formdisabled" class="btn btn-primary">Please Wait Saving Image....</button>
          <button v-else class="btn btn-primary" @click="saveService">Save Changes</button>
          <button type="button" @click.prevent="deleteService" class="btn btn-danger">Delete Service</button>
        </div>
      </card>
    </div>

  </div>

</template>

<script>

import Editor from '@tinymce/tinymce-vue';


    export default {
        name: "AdminEditService",
        middleware: 'admin',
        layout:'admin',
        components: {
          'editor': Editor
        },


      data () { return {
            ErrorMessages:null,
            Service:null,
            Galleries:null,
            formdisabled:false,
        initTiny: {
          menubar:false,
        }
        }},

        mounted() {
            let self=this;
            this.getService();
            self.$axios.get('/api/galleries?hidden=true').then(function (res) {
                self.Galleries=res.data.results;
            })
        },

        methods: {
            getService() {
                let self=this;
                self.ErrorMessages=null;
                self.$axios.get('/api/services/'+self.$route.params.id).then(function (res) {
                    self.Service = res.data
                }).catch((error) => {
                    self.ErrorMessages = error.response.data.errors;
            });
            },
            imageUpload(ref) {
                let self=this;
                self.formdisabled=true;
                let file = self.$refs[ref].files[0];
                let file_image = self.$refs[ref+'_image'];
                //first change the image to a loader
                file_image.src = '/storage/images/loaders/loading-sm.svg';
                //now post the data
                let formData = new FormData();
                formData.append(ref,file);
                formData.append('id',self.Service.id);

                self.$axios.post('/api/services/edit',formData,
                    { headers: {'Content-Type': 'multipart/form-data'}})
                    .then(function (res)  {
                        // get the new data and load just the image incase
                        //the rest has not been saved yet
                        self.$axios.get('/api/services/'+self.$route.params.id).then(function (res) {
                            //got to if this as the appi returns different results to the item_name
                            if(ref==='image_icon') {
                                file_image.src = res.data['imageicon_url'];
                            } else {
                                file_image.src = res.data['imageheader_url'];
                            }
                            //empty out the file so we do not double submit
                            self.$refs[ref].value='';
                            self.formdisabled=false;
                        });
                    });

            },
            saveService() {
                let self=this;
                self.ErrorMessages=null;
                if(self.Service.name.length) {
                    self.$axios.post('/api/services/edit',self.Service).then(function(res) {
                        self.$router.push('/admin/services');
                    });
                } else {
                    self.ErrorMessages=['You must enter a name for this service'];
                }
            },
            deleteService() {
                this.DeleteModal = '';
                let self = this;
                this.$bvModal.msgBoxConfirm('Are you sure you want to delete this?')
                    .then(value => {
                        if(value==true) {
                            self.$axios.get('/api/services/'+self.Service.id+'/delete')
                                .then( function() {
                                    self.$router.push('/admin/services');
                                });

                        }
                    });
            },
          rotateImage(image) {
            let self=this;
            self.loading=true;
            self.$axios.get('/api/services/'+self.Service.id+'/rotate/'+image)
              .then(function (res) {
                self.loading=false;
                self.getService();
              });
          },
        }

    }
</script>

<style lang="scss" scoped>
  .admin-image {
    width:100%;
    justify-content: center;
    text-align: center;
    margin-bottom:10px;
    height:240px;
    display: flex;
    img {
      align-self: center;
      max-height:240px;
      max-width: 250px;
    }
  }
</style>
