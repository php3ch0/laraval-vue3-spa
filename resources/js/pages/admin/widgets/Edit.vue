<template>
    <div id="AdminWidgetsView" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-end mb-4">
            <div class="flex-auto">
                <h1>Edit Widgets</h1>
            </div>
            <div class="justify-self-end flex-none">
                <router-link class="btn btn-secondary ml-4" to="/admin/widgets"><i class="fa-solid fa-circle-arrow-left"></i> Go Back</router-link>
            </div>
        </div>
        <Card title="Manage Widget">
            <Loading v-if="loading" />
            <form @submit.prevent="saveWidget" :class="{'hidden':loading}">

                <div v-if="success" class="mt-3 mb-3 bg-green-200 p-3 rounded border border-green-500">
                  <i class="fa-solid fa-circle-check mr-3"></i>
                  Your Changes Have Been Saved
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-2">
                        <label>Widget Name</label>
                        <input type="text" v-model="item.name" />
                        <div v-if="errors.name" class="form-error">{{ errors.name }}</div>
                    </div>
                    <div class="mb-2">
                        <label>Type</label>
                        <select v-model="item.type">
                            <option value="TEXT">TEXT</option>
                            <option value="IMAGE">IMAGE</option>
                        </select>
                        <div v-if="errors.type" class="form-error">{{ errors.type }}</div>
                    </div>

                </div>

                    <template v-if="item.type==='TEXT'">
                        <div class="mb-2">
                            <label>Description</label>
                            <editor
                                api-key="no-api-key"
                                :disabled=false
                                :init= "{
                                 menubar: false,
                                 plugins: ['advlist autolink lists link paste code'],
                                 toolbar:'pastetext | formatselect | forecolor | bold italic underline strikethrough removeformat | alignleft aligncenter alignright | bullist numlist blockquote | link unlink | code'
                               }"
                                v-model="item.html"
                                :initial-value="item.html"
                                paste_as_text=true
                            />
                        </div>



                    </template>

                    <template v-if="item.type==='IMAGE'">

                        <div class="mb-2">
                            <label>Upload Image</label>
                            <input v-on:change="handleImageUpload()" name="image" type="file" ref="image" class="form-control">
                            <div v-if="errors.file" class="form-error">{{ errors.file }}</div>
                            <progress v-if="item.progress" :value="item.progress.percentage" max="100">
                                {{ item.progress.percentage }}%
                            </progress>

                        </div>

                        <div class="mb-2">
                            <label>Image Alt</label>
                            <input type="text" v-model="item.alt" />
                            <div v-if="errors.alt" class="form-error">{{ errors.alt }}</div>
                        </div>


                    </template>




                <button type="submit" class="btn">Save Changes</button>
            </form>



        </Card>






    </div>
</template>

<script>
import Editor from '@tinymce/tinymce-vue'

export default {
  name: 'AdminWidgetsEdit',

  components: {
    Editor
  },

  data() {
    return {
      item: {},
      loading:false,
      errors:{},
      success:false
    }
  },

  mounted() {
    let self=this;
    self.getWidget();
  },

  methods: {
    getWidget() {
      let self=this;
      self.loading=true;
      axios.get('/api/widgets/'+self.$route.params.id).then(function(res) {
        self.item=res.data;
        self.loading=false;
      }).catch(e=>{
        console.log(e.response.data);
      })
    },
    handleImageUpload(){
      this.item.image = this.$refs.image.files[0];

    },
    saveWidget() {
      let self=this;
      self.loading=true;
      self.errors={};
      self.success=false;

      let formData = new FormData();
      var arr = self.item;
      for (let key in arr) {
        Array.isArray(arr[key])
          ? arr[key].forEach(value => formData.append(key + '[]', value))
          : formData.append(key, arr[key]) ;
      }

      formData.append('image',self.item.image);

      axios.post('/api/widgets/'+self.item.id,formData,
        { headers: {'Content-Type': 'multipart/form-data'}})
        .then(function(res) {
        self.success=true;
        self.loading=false;
        setTimeout(function() {
          self.success=false;
        },3000);
      }).catch(e=> {
        self.errors=e.response.data;
        self.loading=false;
      })
    }
  }
}


</script>
