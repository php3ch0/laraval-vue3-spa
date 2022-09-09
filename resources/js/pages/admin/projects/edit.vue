<template>
    <div class="container-fluid admin-project-edit">
      <div class="flex">
        <div class="flex-auto">
          <h1>Manage Project</h1>
        </div>
        <div class="flex-none">
          <router-link to="/admin/projects" class="btn btn-primary">Go Back</router-link>
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


                    </div>
                  <div class="white-box">

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
                        <div class="form-error" v-if="editItemErrors.image">{{ editItemErrors.image[0] }}</div>
                      </div>

                  </div>
                </div>



                <div  class="wtype-text row">
                    <div class="col">
                        <div class="mb-2 mt-3">
                            <label>Project Description</label>
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

                    <button type="submit" class="btn btn-primary mr-3">Save Changes</button>
                    <confirm-button @confirm="deleteItem" text="Delete Item" />
                </form>
            </div>
        </div>

      <card title="Upload Photos" class="mt-3 mb-3">
        <div id="dropzone" class="dropzone mb-4 mh-[200px] bg-gray-200"></div>
      </card>


      <card title="Photo Gallery" class="mt-3 mb-3">

        <draggable :list="editItem.images" item-key="id" @change="sortEnd" class="grid grid-cols-4 gap-4" >
          <template #item="{element}">
            <div class="galleryImage">
              <div class="controls flex">
                <button type="button" class="justify-self-start"><i class="fa-solid fa-arrows-up-down-left-right"></i></button>
                <button type="button" @click="rotateImage(element.id)" class="justify-self-end"><i class="fa-solid fa-rotate"></i></button>
                <button type="button" @click="deleteImage(element.id)" class="justify-self-end"><i class="fa-solid fa-trash"></i></button>
              </div>
              <div class="image">
                <img :src="element.image_url" :alt="editItem.title" />
              </div>
              <div class="short-code text-center">
                {{ element.short_code }}
              </div>
            </div>
          </template>

        </draggable>




      </card>


      <p><strong>Notes:</strong></p>
      <p>You can set width of items like so: [[image50=1]] [[image100=4]]</p>
      <p>Available widths = 100,80,66,50,33</p>



    </div>

</template>

<script>

  import Editor from '@tinymce/tinymce-vue';
  import { Dropzone } from "dropzone";
  import 'dropzone/dist/dropzone.css';
  import draggable from 'vuedraggable';

    export default {
        middleware: 'admin',
        layout: 'admin',
        name:'adminProjectEdit',
        components: {
          'editor': Editor,
          draggable
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
            url:'/api/projectsimages',
            uploadMultiple:false,
            acceptedFiles:'image/*',
            clickable:true,
            parallelUploads:2,
          });
          dz.on('sending', function(data, xhr, formData){
            formData.append('project_id', self.$route.params.id);
          });
          dz.on("complete", function(file) {
            dz.removeFile(file);
            self.getItem();

          });

        },
        methods: {

            getItem() {
              let self=this;
              self.editItem.id = self.$route.params.id;
              axios.get('/api/projects/'+self.editItem.id).then(function (res) {
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


                axios.post('/api/projects/'+self.editItem.id,
                    formData,
                    { headers: {'Content-Type': 'multipart/form-data'}})
                .then(function (res) {
                    self.$router.push({path: '/admin/projects'});
                }).catch(e => {
                      self.loading=false;

                      if(e.response.status===413) {
                        self.editItemErrors.image=['The image you have uploaded is too large'];
                      }
                      if(e.response.data) {
                        self.editItemErrors=e.reponse.data;
                      }



                  });
            },

            deleteItem() {
              let self=this;
              axios.delete('/api/projects/'+self.editItem.id).then(function(res) {
                self.$router.push('/admin/projects');
              })
            },

            sortEnd() {
              let self=this;
              axios.post('/api/projectsimages/order',self.editItem);
            },

            deleteImage(id) {
              let self=this;
              axios.delete('/api/projectsimages/'+id).then(function(res) {
                self.getItem();
              })
            },

            rotateImage(id) {
              let self=this;
              axios.post('/api/projectsimages/'+id+'/rotate', { 'id':id }).then(function(res) {
                self.getItem();
              });
            },


        }
    }

</script>
