<template>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 col-lg-6 mb-3 text-center text-lg-start">
          <h1>Manage Galleries</h1>
        </div>
        <div class="col-12 col-lg-6 mb-3 text-center text-lg-end">
          <router-link to="/admin/galleries" class="btn btn-primary">Go Back</router-link>
        </div>
      </div>


      <div class="row">
        <div class="col-12 col-lg-6">
          <div v-if="item" class="card card-default">
            <div class="card-header">Manage Gallery</div>
            <div class="card-body">
              <div v-if="editErrors" class="alert alert-danger mb-3">
                <div v-for="Error in editErrors">
                  {{ Error[0] }}
                </div>
              </div>
              <div v-if="editMessages" class="alert alert-success mb-3">
                You changes have been saved
              </div>
              <form class="form" enctype="multipart/form-data">
                <div class="row">
                  <div class="col">
                    <div class="mb-2">
                      <label for="name">Gallery Name:</label>
                      <input v-model="item.name" type="text" class="form-control">
                    </div>
                    <div class="mb-2">
                      <label for="name">Gallery URL:</label>
                      <input v-model="item.slug" type="text" class="form-control">
                    </div>
                    <div class="mb-2">
                      <label for="name">Show On Gallery Page:</label>
                      <select v-model="item.show" class="form-control">
                        <option value="N" :selected="(item.show !== 'Y')">No</option>
                        <option value="Y" :selected="(item.show === 'Y')">Yes</option>
                      </select>
                    </div>


                  </div>
                </div>




                <button @click.prevent="updateItem" class="btn btn-primary btn-saving">Save Changes</button>
                <a class="btn btn-danger ms-2" @click="deleteItem">Delete</a>
              </form>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-6">
        <card title="Upload Photos">
          <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" @vdropzone-queue-complete="onDropzoneSuccess"></vue-dropzone>
        </card>
        </div>

      </div>


      <hr>
      <card v-if="item" title="Gallery Images">
        <draggable v-if="item.images" v-model="item.images" element="div" @start="drag=true" @end="onSortEnd()" class="row">
          <div v-for="Image in item.images" class="col-4 col-lg-3" :ref="'img'+Image.id" :key="Image.orderby">
            <gimage :id="Image.id" @deleteImage="deleteImage" @viewCaption="viewCaption" @rotateImage="rotateImage" />
          </div>
        </draggable>
      </card>


      <b-modal id="bv-modal" ref="captionModal" hide-footer>
        <template slot="modal-title">
          Update Caption
        </template>
        <div class="d-block">
          <form>
            <div class="mb-2">
              <label>Image Caption / Title</label>
              <b-form-input v-model="thisImage.caption" ref="imageCaption" class="form-control"></b-form-input>
            </div>
            <div class="mb-2">
              <label>Image Sub Caption</label>
              <b-form-input v-model="thisImage.caption_sub" ref="imageCaptionSub" class="form-control"></b-form-input>
            </div>
            <div class="mb-2">
              <label>URL / Link</label>
              <b-form-input v-model="thisImage.url" ref="imageURL" class="form-control"></b-form-input>
            </div>

            <button v-on:click="updateCaption" class="btn btn-primary">Save Changes</button>
          </form>
        </div>

      </b-modal>

    </div>


</template>

<script>

    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'
    import gimage from './components/gimage'
    import draggable from 'vuedraggable';
    import Swal from 'sweetalert2';

    export default {
        middleware: 'admin',
        layout: 'admin',
        name:'adminGalleryEdit',
        items:null,
        components: {
            vueDropzone: vue2Dropzone,
            gimage,
            draggable,
        },

      metaInfo () {
        let self = this;
        return {
          title: 'Admin Portal',
          meta: [
            {name: 'description',content: 'Manage the setting of your website'},
          ]
        }
      },


        data() {
            return {
                item: null,
                id:null,
                editErrors:null,
                editMessages:null,
                DeleteModal:null,
                thisImages:null,
                imageOrder: null,
                successMessage:null,
                thisImage: {}
            }

        },

        computed:  {
            dropzoneOptions: function() {
                return {
                    url: '/api/galleries/images',
                    thumbnailWidth: 50,
                    maxFilesize: 8,
                    acceptedFiles: 'image/*',
                    params: {gallery_id: this.$route.params.id},

                }
            }
        },

        created: function () {

                this.id = this.$route.params.id;
                this.getItem();


        },
        methods: {

          getItem() {
            let self=this;
            self.item={};
            self.$axios.get('/api/galleries/'+self.id).then(function (res) {

              self.item=res.data.results;
            }).catch(error => {
              console.log(error.response.data.status);
              Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Error: '+error.response.data.status
              })
            });
          },


          updateItem() {
            let self = this;
            self.editErrors=null;
            self.editMessages=null;

            self.$axios.patch('/api/galleries',self.item).then(function (res) {
              self.editMessages = "Changes Saved";
              self.getItem();

              setTimeout(function() {
                self.editMessages=null;
              },2000);

            }).catch(error => {
              self.editErrors = error.response.data.errors;
            });
          },

          deleteItem() {
            this.DeleteModal = '';
            let self = this;
            this.$bvModal.msgBoxConfirm('Are you sure you want to delete this?')
              .then(value => {
                if(value==true) {
                  self.$axios.delete('/api/galleries/'+self.item.id)
                    .then(function () {
                      self.$router.push({path: '/admin/galleries'});
                    }).catch(error => {
                    console.log(error.response.data);
                    Swal.fire({
                      type: 'error',
                      title: 'Oops...',
                      text: 'Error: '+error.response.data.status
                    })
                  });
                }
              })
          },

          viewCaption(ImageId) {
                //reset this image
                let self=this;
                self.thisImage={};
                self.$axios.get('/api/galleries/images/'+ImageId).then(function (res) {
                    self.thisImage =  res.data.results;
                    self.$refs['captionModal'].show();
                });
            },
            updateCaption(e) {
                let self=this;
                e.preventDefault();
                self.$axios.patch('/api/galleries/images',
                    self.thisImage)
                    .then(function (res) {
                        self.$refs['captionModal'].hide();
                    });
            },
            rotateImage(ImageId) {
                let self=this;

                self.$axios.patch('/api/galleries/images/'+ImageId+'/rotate')
                    .then(function (res) {
                        self.thisImage={};
                        self.getItem();
                    });
            },

            onDropzoneSuccess() {
                this.$refs.myVueDropzone.removeAllFiles();
                this.getItem();
            },
            deleteImage(imageId) {
                this.DeleteModal = '';
                let self = this;
                self.thisImage.id=imageId;
                this.$bvModal.msgBoxConfirm('Are you sure you want to delete this?')
                    .then(value => {
                        if(value==true) {
                            self.$axios.delete('/api/galleries/images/'+self.thisImage.id)
                                .then( function() {
                                  self.getItem();
                                });

                        }
                    });
            },

            onSortEnd() {
                let self = this;
                self.$axios.post('/api/galleries/images/order',this.item.images).then(function(res) {
                  self.getItem();
                });
            }

        }
    }


</script>
