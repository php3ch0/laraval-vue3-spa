<template>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 col-lg-8">
          <h1>Manage Widgets</h1>
        </div>
        <div class="col-12 col-lg-4 text-end">
          <router-link to="/admin/widgets" class="btn btn-primary">Go Back</router-link>
        </div>
      </div>


        <div v-if="thisWidget" class="card card-default mt-3">
            <div class="card-header">Manage Widget</div>
            <div class="card-body">
                <div v-if="ErrorMessages" class="alert alert-danger mb-3">
                    <div v-for="Error in ErrorMessages">
                        {{ Error[0] }}
                    </div>
                </div>
                <form class="form" enctype="multipart/form-data">
                <div class="row">
                    <div class="col">
                        <div class="mb-2">
                            <label for="name">Widget Name:</label>
                            <input v-model="thisWidget.name" type="text" class="form-control">
                        </div>

                        <div class="mb-2">
                            <label for="name">Widget Type:</label>
                            <select v-model="thisWidget.type" type="text" class="form-control">
                                <option value="TEXT">TEXT</option>
                                <option value="IMAGE">IMAGE</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div  class="wtype-text row" :class="{ 'd-none': isImage }">
                    <div class="col">
                        <div class="mb-2">
                            <label>Widget Text</label>
                          <editor
                            api-key="no-api-key"
                            :disabled=false
                            :init= "initTiny"
                            v-model="thisWidget.data"
                            :initial-value="thisWidget.data"
                            :inline=false
                            plugins="code link lists powerpaste image media"
                            paste_as_text=true
                            powerpaste_word_import="clean"
                            powerpaste_html_import= "clean"
                            powerpaste_clean_filtered_inline_elements="em, b, i, u, strike, sup, sub, font style"
                            toolbar="pastetext | formatselect | forecolor | bold italic underline strikethrough removeformat | alignleft aligncenter alignright | bullist numlist blockquote | link unlink | code"
                          />


                        </div>
                    </div>


                </div>

                <div  class="wtype-image row" :class="{ 'd-none': isText }">

                    <div class="col-8">
                        <div class="mb-2">
                            <label for="image">Image File:</label>
                            <input v-on:change="handleFileUpload()" name="image" type="file" ref="file" class="form-control">
                        </div>

                        <div class="mb-2">
                            <label>Link</label>
                            <input v-model="thisWidget.url" type="text" class="form-control">

                        </div>

                        <div class="mb-2">
                            <label>Alt Text</label>
                            <input v-model="thisWidget.alt" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="ml-3">
                            <div style="border:2px dotted #ccc; padding:10px; max-height:300px; overflow: hidden;">
                               <widget :name="$route.params.id"></widget>
                            </div>
                        </div>
                    </div>

                </div>


                    <button v-on:click="doUpdate" type="submit" class="btn btn-primary">Save Changes</button>

                    <a class="btn btn-danger ml-2" @click="showDeleteModal" >Delete</a>

                </form>
            </div>
        </div>



    </div>

</template>

<script>

    import Editor from '@tinymce/tinymce-vue';
    import widget from '~/components/Widget'
    const axios = require('axios').default;

    export default {
        middleware: 'admin',
        layout: 'admin',
        name:'adminWidgetsEdit',
        components: {
            widget,
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
              thisWidget: {},
              id: null,

              ErrorMessages: null,
              file: null,
              content: null,
              DeleteModal: null,
              initTiny: {
                menubar:false,
              }

            }
        },

        computed: {
            isImage: function() {
                if(this.thisWidget.type=='IMAGE') { return true; } return false;
            },
            isText: function() {
                if(this.thisWidget.type=='TEXT') { return true; } return false;
            }
        },

        mounted() {
          let self = this;
          self.$axios.get('/api/widgets/' + self.$route.params.id).then(function (res) {
            self.thisWidget = res.data;
          });




        },
        methods: {
            handleFileUpload(){
                this.file = this.$refs.file.files[0];
            },
            doUpdate: function(e) {
                let self = this;
                e.preventDefault();

                let formData = new FormData();

                var arr = self.thisWidget;
                for (let key in arr) {
                    Array.isArray(arr[key])
                        ? arr[key].forEach(value => formData.append(key + '[]', value))
                        : formData.append(key, arr[key]) ;
                }

                formData.append('image',this.file);

                self.$axios.post('/api/widgets/'+self.thisWidget.id,
                    formData,
                    { headers: {'Content-Type': 'multipart/form-data'}})
                .then(function (res) {
                    if(res.status=='error') {
                        self.ErrorMessages = res.errors;
                    } else {
                        self.$router.push({path: '/admin/widgets'});
                    }

                });
            },
            showDeleteModal() {
                this.DeleteModal = '';
                let self = this;
                this.$bvModal.msgBoxConfirm('Are you sure you want to delete this?')
                    .then(value => {
                        if(value==true) {
                            self.$axios.delete('/api/widgets/'+self.thisWidget.id)
                                .then(function () {
                                    self.$router.push({path: '/admin/widgets'});
                                });
                        }
                    })
            },


        }
    }

</script>
