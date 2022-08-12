<template>
  <div id="AdminGalleryEdit" class="container-fluid admin-blog-edit">
    <div class="flex">
      <div class="flex-auto">
        <h1>Manage Gallery</h1>
      </div>
      <div class="flex-none">
        <ConfirmButton text="Delete Gallery" class="mr-3" @confirm="deleteGallery" />
        <router-link to="/admin/galleries" class="btn btn-primary">Go Back</router-link>
      </div>
    </div>



    <div class="card card-default mt-3">
      <div class="card-header">Manage Gallery</div>
      <div class="card-body">
        <form  @submit.prevent="editItemSubmit" class="form" enctype="multipart/form-data">


          <div class="grid grid-cols-2 gap-4">
            <div class="">
              <div class="mb-2">
                <label for="name">Name:</label>
                <input v-model="editItem.name" type="text" :class="{'error':editItemErrors.name }" >
                <div class="form-error" v-if="editItemErrors.title">{{ editItemErrors.name[0] }}</div>
              </div>
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>

            <div>
              <div id="dropzone" class="dropzone mb-4 mh-[200px] bg-gray-200"></div>
            </div>

          </div>




        </form>
      </div>
    </div>



    <card title="Photo Gallery" class="mt-3 mb-3">

      <draggable :list="editItem.images" item-key="id" @change="sortEnd" class="grid grid-cols-4 gap-4" >
        <template #item="{element}">
          <div class="galleryImage">
            <div class="controls flex">
              <button type="button" class="justify-self-start"><i class="fa-solid fa-arrows-up-down-left-right"></i></button>
              <button type="button" @click.prevent="editImageModalToggle(element)" class="justify-self-start"><i class="fa-solid fa-pen-to-square"></i></button>
              <button type="button" @click="rotateImage(element.id)" class="justify-self-end"><i class="fa-solid fa-rotate"></i></button>
              <button type="button" @click="deleteImage(element.id)" class="justify-self-end"><i class="fa-solid fa-trash"></i></button>
            </div>
            <div class="image">
              <img :src="element.image_url" :alt="editItem.name" />
            </div>
          </div>
        </template>

      </draggable>




    </card>


    <Modal :show="editImageModal" @close="editImageModalToggle" width="lg" title="Update Image">
      <template #body>
        <Loading v-if="editImageLoading" />
        <form v-else @submit.prevent="editImageSubmit">

          <div class="mb-2">
            <label>Image Name</label>
            <input type="text" v-model="editImage.alt" :class="{'error':(editImageErrors.alt)}" />
            <div class="form-error" v-if="editImageErrors.alt">{{ editImageErrors.alt[0] }}</div>
          </div>

          <div class="mb-2">
            <label>Image Link</label>
            <input type="text" v-model="editImage.link" :class="{'error':(editImageErrors.link)}" />
            <div class="form-error" v-if="editImageErrors.link">{{ editImageErrors.link[0] }}</div>
          </div>

          <hr>
          <div class="text-center p-3">
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </template>
    </Modal>





  </div>

</template>

<script>


import { Dropzone } from "dropzone";
import 'dropzone/dist/dropzone.css';
import draggable from 'vuedraggable'

export default {
  middleware: 'admin',
  layout: 'admin',
  name:'adminGalleryEdit',
  components: {
    draggable
  },

  data() {
    return {
      editItem: {},
      editItemErrors:{},
      ErrorMessages:null,
      DeleteModal:null,
      editImage: {},
      editImageErrors:{},
      editImageLoading:true,
      editImageModal:false,
      loading:false,
    }
  },

  mounted() {
    let self=this;
    self.getItem();
    let dz = new Dropzone("div#dropzone", {
      url:'/api/galleriesimages',
      uploadMultiple:false,
      acceptedFiles:'image/*',
      clickable:true,
      parallelUploads:2,
    });
    dz.on('sending', function(data, xhr, formData){
      formData.append('gallery_id', self.$route.params.id);
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
      axios.get('/api/galleries/'+self.editItem.id).then(function (res) {
        self.editItem=res.data;
      });
    },

    editItemSubmit() {
      let self = this;
      self.loading=true;
      self.editItemErrors={};

      let formData = new FormData();

      var arr = self.editItem;
      for (let key in arr) {
        Array.isArray(arr[key])
          ? arr[key].forEach(value => formData.append(key + '[]', value))
          : formData.append(key, arr[key]) ;
      }

      axios.post('/api/galleries/'+self.editItem.id,
        formData,
        { headers: {'Content-Type': 'multipart/form-data'}})
        .then(function (res) {
          self.$router.push({path: '/admin/galleries'});
        }).catch(e => {
        self.loading=false;
        self.editItemErrors=e.reponse.data;
      });
    },

    deleteGallery() {
      let self=this;
      axios.delete('/api/galleries/'+self.editItem.id).then(function(res) {
        self.$router.push('/admin/galleries');
      })
    },

    sortEnd() {
      let self=this;
      axios.post('/api/galleriesimages/order',self.editItem);
    },
    deleteImage(id) {
      let self=this;
      console.log(id);
      axios.delete('/api/galleriesimages/'+id).then(function(res) {
        self.getItem();
      })
    },
    rotateImage(id) {
      let self=this;
      axios.post('/api/galleriesimages/'+id+'/rotate', { 'id':id }).then(function(res) {
        self.getItem();
      });
    },
    editImageModalToggle(image=null) {
      let self=this;
      self.editImageLoading=false;
      if(self.editImageModal) {
        self.editImage={};
        self.editImageModal=false;
      } else {
        self.editImage=image;
        self.editImageModal=true;
      }

    },

    editImageSubmit() {
      let self=this;
      self.editImageLoading=true;
      axios.post('/api/galleriesimages/'+self.editImage.id,self.editImage).then(function(res) {
        self.editImageLoading=false;
      }).catch(e=> {
        self.editImageErrors=e.response.data;
        self.editImageLoading=false;
      })
    }

  }
}

</script>
