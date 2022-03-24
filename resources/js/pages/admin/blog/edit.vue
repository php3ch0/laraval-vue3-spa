<template>
    <div class="container-fluid admin-blog-edit">
      <div class="row">
        <div class="col-8">
          <h1>Manage Blog</h1>
        </div>
        <div class="col-4 text-end">
          <router-link to="/admin/blog" class="btn btn-primary">Go Back</router-link>
        </div>
      </div>



        <div class="card card-default mt-3">
            <div class="card-header">Manage Item</div>
            <div class="card-body">
                <div v-if="ErrorMessages" class="alert alert-danger mb-3">
                    <div v-for="Error in ErrorMessages">
                        {{ Error[0] }}
                    </div>
                </div>
                <form  @submit.prevent="doUpdate" class="form" enctype="multipart/form-data">


                <div class="row">
                    <div class="col">

                      <div class="mb-2">
                        <label for="name">Title:</label>
                        <input v-model="thisItem.title" type="text" class="form-control">
                      </div>

                      <div class="mb-2">
                        <label for="name">Item Slug URL:</label>
                        <input v-model="thisItem.slug" type="text" class="form-control">
                      </div>

                      <div class="mb-2">
                        <label>PDF File</label>
                        <input v-on:change="handleFileUpload()" name="image" type="file" ref="file" class="form-control">
                      </div>

                    </div>
                  <div class="col">
                    <card title="Blog Image">
                      <div class="mb-2">
                        <div class="row justify-content-center mb-2 mt-3">
                          <div class="col">
                            <div class="img-wrap text-center" style="margin:0 auto; text-center">
                              <img :src="thisItem.imageurl" :alt="thisItem.title" style="max-width: 100%; max-height: 240px;" />
                            </div>
                          </div>
                        </div>
                        <label for="image">Image:</label>
                        <input v-on:change="handleImageUpload()" name="image" type="file" ref="image" class="form-control">
                      </div>
                    </card>
                  </div>
                </div>



                <div  class="wtype-text row">
                    <div class="col">
                        <div class="mb-2 mt-3">
                            <label>Article</label>
                          <editor
                            api-key="no-api-key"
                            :disabled=false
                            :init= "initTiny"
                            v-model="thisItem.article"
                            :initial-value="thisItem.article"
                            :inline=false
                            plugins="code link lists paste image media"
                            paste_as_text: true
                            toolbar="formatselect | forecolor | bold italic underline strikethrough removeformat | alignleft aligncenter alignright | bullist numlist blockquote | link unlink | code"
                          />
                          <input type='file' name='fileupload' id='fileupload' style='display: none;'>
                        </div>
                    </div>


                </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a class="btn btn-danger ml-2" @click="showDeleteModal" >Delete</a>
                </form>
            </div>
        </div>

      <card title="Upload Photos" class="mt-3 mb-3">
        <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" @vdropzone-queue-complete="onDropzoneSuccess"></vue-dropzone>
      </card>

      <card title="Photo Gallery" class="mt-3 mb-3">
        <div v-if="thisItem.images" class="row">
          <div v-for="image in thisItem.images" class="col-3">
            <div class="admin-blog-image">
              <div class="controls text-right"><button type="button" class="btn btn-sm btn-danger" @click.prevent="deleteImage(image.id)" style="padding:5px 15px;"><i class="fas fa-times"></i></button> </div>
              <img :src="image.image_url" alt="Image" />
            </div>
            <div class="short-code text-center">
              {{ image.short_code }}
            </div>
          </div>
        </div>
      </card>

      <p><strong>Notes:</strong></p>
      <p>You can set width of items like so: [[image50=1]] [[image100=4]]</p>
      <p>Available widths = 100,80,66,50,33</p>



    </div>

</template>

<script>

  import Editor from '@tinymce/tinymce-vue';
  const axios = require('axios').default;
  import vue2Dropzone from 'vue2-dropzone'
  import 'vue2-dropzone/dist/vue2Dropzone.min.css'

    export default {
        middleware: 'admin',
        layout: 'admin',
        name:'adminBlogEdit',
        components: {
          'editor': Editor,
        vueDropzone: vue2Dropzone
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
      computed:  {
        dropzoneOptions: function() {
          return {
            url: '/api/blog/0/images',
            thumbnailWidth: 50,
            maxFilesize: 8,
            acceptedFiles: 'image/*',
            params: {blog_id: this.$route.params.id},

          }
        }
      },

        data() {
            return {
                thisItem: {},
                ErrorMessages:null,
                DeleteModal:null,
                tmpFile: {},
                tmpAddFile:null,
                addFileErrors:null,
                AddLoading:false,
                initTiny: {
                menubar:false,

                file_picker_callback: function(callback, value, meta) {
                  // Trigger click on file element
                  let uploader = document.getElementById("fileupload");
                  uploader.value=null
                  uploader.click();

                  uploader.onchange = function() {

                    let file = this.files[0];
                    let fd = new FormData();
                    fd.append("file",file);

                    axios.post('/api/uploader', fd, { headers: {'Content-Type': 'multipart/form-data'}})
                      .then(function (res) {
                        callback(res.data.file,{'text':res.data.file});
                      });
                  }


                }
              }
            }
        },

        mounted() {
            this.getItem();

        },
        methods: {

            getItem() {
              let self=this;
              self.thisItem.id = self.$route.params.id;
              self.$axios.get('/api/blog/'+self.thisItem.id).then(function (res) {
                self.thisItem=res.data;
              });
            },

            handleImageUpload(){
                this.thisItem.image = this.$refs.image.files[0];

            },
            handleFileUpload(){
              this.thisItem.file = this.$refs.file.files[0];
            },
            doUpdate: function(e) {
                let self = this;
                self.ErrorMessages=null;

                let formData = new FormData();

                var arr = self.thisItem;
                for (let key in arr) {
                    Array.isArray(arr[key])
                        ? arr[key].forEach(value => formData.append(key + '[]', value))
                        : formData.append(key, arr[key]) ;
                }

                formData.append('image',self.thisItem.image);
                formData.append('file',self.thisItem.file);


                self.$axios.post('/api/blog/'+self.thisItem.id,
                    formData,
                    { headers: {'Content-Type': 'multipart/form-data'}})
                .then(function (res) {
                    self.$router.push({path: '/admin/blog'});
                }).catch(error => {
                      self.ErrorMessages = error.response.data;
                  });
            },
            showDeleteModal() {
                this.DeleteModal = '';
                let self = this;
                this.$bvModal.msgBoxConfirm('Are you sure you want to delete this?')
                    .then(value => {
                        if(value==true) {
                            self.$axios.delete('/api/blog/'+self.thisItem.id)
                                .then(function () {
                                    self.$router.push({path: '/admin/blog'});
                                });
                        }
                    })
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
          deleteImage(id) {
            this.DeleteModal = '';
            let self = this;
            this.$bvModal.msgBoxConfirm('Are you sure you want to delete this? Make sure you have saved other changes first.')
              .then(value => {
                if(value==true) {
                  self.$axios.delete('/api/blog/'+self.thisItem.id+'/images/'+id)
                    .then(function () {
                      self.getItem();
                    });
                }
              })
          },




        }
    }

</script>
