<template>
    <div class="container-fluid admin-blog-edit">
      <div class="flex">
        <div class="flex-auto">
          <h1>Manage Blog</h1>
        </div>
        <div class="flex-none">
          <router-link to="/admin/blog" class="btn btn-primary">Go Back</router-link>
        </div>
      </div>



        <div class="card card-default mt-3">
            <div class="card-header">Manage Item</div>
            <div class="card-body">
                <form  @submit.prevent="editItemSubmit" class="form" enctype="multipart/form-data">


                <div class="grid grid-cols-2 gap-4">
                    <div class="">

                      <div class="mb-2">
                        <label for="name">Title:</label>
                        <input v-model="editItem.title" type="text" :class="{'error':editItemErrors.title }" >
                        <div class="form-error" v-if="editItemErrors.title">{{ editItemErrors.title[0] }}</div>
                      </div>

                      <div class="mb-2">
                        <label for="name">Item Slug URL:</label>
                        <input v-model="editItem.slug" type="text" :class="{'error':editItemErrors.slug }">
                        <div class="form-error" v-if="editItemErrors.slug">{{ editItemErrors.slug[0] }}</div>
                      </div>

                      <div class="mb-2">
                        <label>Change Publish Date</label>
                        <Datepicker v-model="editItem.created_at" format="dd/MM/yyyy" :autoApply="true" :enableTimePicker="false"></Datepicker>
                        <div class="form-error" v-if="editItemErrors.created_at">{{ editItemErrors.created_at[0] }}</div>
                      </div>

                    </div>
                  <div class="">
                    <card title="Blog Image">
                      <div class="mb-2">
                        <div class="row justify-content-center mb-2 mt-3">
                          <div class="col">
                            <div class="flex place-content-center" style="margin:0 auto;">
                              <img :src="editItem.image_url" :alt="editItem.title" style="max-width: 100%; max-height: 240px;" />
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
                            :init= "{
                                 menubar: false,
                                 plugins: ['advlist autolink lists link paste code'],
                                 toolbar:'pastetext | formatselect | forecolor | bold italic underline strikethrough removeformat | alignleft aligncenter alignright | bullist numlist blockquote | link unlink | code'
                               }"
                            v-model="editItem.article"
                            :initial-value="editItem.article"
                            paste_as_text=true
                          />
                        </div>
                    </div>


                </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a class="btn btn-danger ml-2" @click="showDeleteModal" >Delete</a>
                </form>
            </div>
        </div>

      <card title="Upload Photos" class="mt-3 mb-3">
        <div id="dropzone" class="dropzone mb-4 mh-[200px] bg-gray-200"></div>
      </card>

      <card title="Photo Gallery" class="mt-3 mb-3">
        <div v-if="editItem.images" class="row">
          <div v-for="image in editItem.images" class="col-3">
            <div class="admin-blog-image">
              <div class="controls text-right"><button type="button" class="btn btn-sm btn-danger" @click.prevent="deleteImage(image.id)" style="padding:5px 15px;"><i class="fas fa-times"></i></button> </div>
              <img :src="image.image_url" alt="Image" class="" />
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
  import Datepicker from '@vuepic/vue-datepicker';
  import '@vuepic/vue-datepicker/dist/main.css';
  import { Dropzone } from "dropzone";
  import 'dropzone/dist/dropzone.css';

    export default {
        middleware: 'admin',
        layout: 'admin',
        name:'adminBlogEdit',
        components: {
          Datepicker,
          'editor': Editor
        },

        data() {
            return {
                editItem: {},
                editItemErrors:{},
                ErrorMessages:null,
                DeleteModal:null,
                tmpFile: {},
                loading:false,
            }
        },

        mounted() {
          let self=this;
          self.getItem();
          let dz = new Dropzone("div#dropzone", {
            url:'/api/blog/'+self.editItem.id+'/images',
            uploadMultiple:false,
            acceptedFiles:'image/*',
            clickable:true,
            parallelUploads:2,
          });
          dz.on("complete", function(file) {
            dz.removeFile(file);
            self.$props.product.images.push(file);

          });

        },
        methods: {

            getItem() {
              let self=this;
              self.editItem.id = self.$route.params.id;
              axios.get('/api/blog/'+self.editItem.id).then(function (res) {
                self.editItem=res.data;
              });
            },

            handleImageUpload(){
                this.editItem.image = this.$refs.image.files[0];

            },

            editItemSubmit() {
                let self = this;
                self.loading=true;
                self.editItemErrors={};

                let formData = new FormData();

                self.editItem.created_at = new Date(self.editItem.created_at).toISOString();

                var arr = self.editItem;
                for (let key in arr) {
                    Array.isArray(arr[key])
                        ? arr[key].forEach(value => formData.append(key + '[]', value))
                        : formData.append(key, arr[key]) ;
                }

                formData.append('image',self.editItem.image);


                axios.post('/api/blog/'+self.editItem.id,
                    formData,
                    { headers: {'Content-Type': 'multipart/form-data'}})
                .then(function (res) {
                    self.$router.push({path: '/admin/blog'});
                }).catch(e => {
                      self.loading=false;
                      self.editItemErrors=e.reponse.data;
                  });
            },


        }
    }

</script>
