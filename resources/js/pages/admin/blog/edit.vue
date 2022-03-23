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

                      <div class="form-group">
                        <label for="name">Title:</label>
                        <input v-model="thisItem.title" type="text" class="form-control">
                      </div>

                      <div class="form-group">
                        <label for="name">Item Slug URL:</label>
                        <input v-model="thisItem.slug" type="text" class="form-control">
                      </div>



                    </div>
                  <div class="col">
                    <card title="Blog Image">
                      <div class="form-group">
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
                        <div class="form-group mt-3">
                            <label>Article</label>
                          <editor
                            api-key="no-api-key"
                            :disabled=false
                            :init= "initTiny"
                            v-model="thisItem.article"
                            :initial-value="thisItem.article"
                            :inline=false
                            plugins="code link lists powerpaste image media"
                            powerpaste_word_import="clean"
                            powerpaste_html_import= "clean"
                            powerpaste_clean_filtered_inline_elements="em, b, i, u, strike, sup, sub, font"
                            toolbar="formatselect | forecolor | bold italic underline strikethrough removeformat | alignleft aligncenter alignright | bullist numlist blockquote | link unlink | code"
                          />
                          <input type='file' name='fileupload' id='fileupload' style='display: none;'>
                        </div>
                    </div>


                </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a class="btn btn-danger ms-2" @click="showDeleteModal" >Delete</a>
                </form>
            </div>
        </div>



    </div>

</template>

<script>

  import Editor from '@tinymce/tinymce-vue';
  const axios = require('axios').default;

    export default {
        middleware: 'admin',
        layout: 'admin',
        name:'adminBlogEdit',
        components: {
          'editor': Editor
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
            let self=this;
                self.thisItem.id = self.$route.params.id;
                self.$axios.get('/api/blog/'+self.thisItem.id).then(function (res) {
                    self.thisItem=res.data;
                });

        },
        methods: {

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




        }
    }

</script>
