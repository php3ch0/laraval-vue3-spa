<template>
  <div id="AdminTestimonialsPage" class="container-fluid">
    <div class="flex">
      <div class="flex-auto">
        <h1>Manage Testimonials</h1>
      </div>
      <div class="flex-none justify-end">
        <a href="#" @click.prevent="toggleAddTestimonialModal" class="btn btn-primary">Add Testimonial</a>
        <router-link to="/admin" class="btn btn-secondary ml-3">Go Back</router-link>
      </div>
    </div>


    <div class="card card-default mt-3">
      <div class="card-header">Manage Testimonials</div>
      <div class="card-body">

        <div v-if="addTestimonialSuccess" class="alert alert-success">Testimonial Added Successfully</div>
        <div v-if="editTestimonialSuccess" class="alert alert-success">Testimonial Changes Saved</div>

       <table class="table">
         <thead>
           <tr>
             <th>Name</th>
             <th>Score</th>
             <th></th>
           </tr>
         </thead>
         <tbody>
           <tr v-for="item in items">
             <td>{{ item.name }}</td>
             <td> <star-rating v-model:rating="item.score" :show-rating="false" :star-size="25" :read-only="true"></star-rating></td>
             <td class="text-right"><button type="button" @click.prevent="toggleEditTestimonialModal(item.id)" class="btn btn-sm btn-primary">Edit</button></td>
           </tr>
         </tbody>
       </table>

      </div>
    </div>
    <div class="mt-3 justify-content-center d-flex text-center">
      <pagination v-model="page" :records="totalRows" :per-page="perPage" @paginate="getItems"/>
    </div>


    <Modal :show="addTestimonialModal" @close="toggleAddTestimonialModal" width="lg" title="Add Testimonial">
      <template #body>
        <Loading v-if="loading" />
        <form v-else @submit.prevent="addTestimonialSubmit">

              <div class="mb-2">
                <label>Testimonial Name</label>
                <input type="text" v-model="addTestimonial.name" :class="{'error':(addTestimonialErrors.name)}" />
                <div class="form-error" v-if="addTestimonialErrors.name">{{ addTestimonialErrors.name[0] }}</div>
              </div>
              <div class="mb-2">
                <label>Rating</label>
                <star-rating v-model:rating="addTestimonial.score" :show-rating="false" :star-size="30" :read-only="false"></star-rating>
              </div>
              <div class="mb-2">
                <label>Testimonial Text</label>
                <editor
                  api-key="no-api-key"
                  :disabled=false
                  :init= "{
                                 menubar: false,
                                 plugins: ['advlist autolink lists link paste code'],
                                 toolbar:'pastetext | formatselect | forecolor | bold italic underline strikethrough removeformat | alignleft aligncenter alignright | bullist numlist blockquote | link unlink | code'
                               }"
                  v-model="addTestimonial.review"
                  :initial-value="addTestimonial.review"
                  paste_as_text=true
                />
              </div>

          <hr>
          <div class="text-center p-3">
            <button type="submit" class="btn btn-primary">Add Testimonial</button>
          </div>
        </form>
      </template>
    </Modal>

    <Modal :show="editTestimonialModal" @close="toggleEditTestimonialModal" width="lg" title="Edit Testimonial">
      <template #body>
        <Loading v-if="loading" />
        <form v-else @submit.prevent="editTestimonialSubmit">

          <div class="mb-2">
            <label>Testimonial Name</label>
            <input type="text" v-model="editTestimonial.name" :class="{'error':(editTestimonialErrors.name)}" />
            <div class="form-error" v-if="editTestimonialErrors.name">{{ editTestimonialErrors.name[0] }}</div>
          </div>
          <div class="mb-2">
            <label>Rating</label>
            <star-rating v-model:rating="editTestimonial.score" :show-rating="false" :star-size="30" :read-only="false"></star-rating>
          </div>
          <div class="mb-2">
            <label>Testimonial Text</label>
            <editor
              api-key="no-api-key"
              :disabled=false
              :init= "{
                                 menubar: false,
                                 plugins: ['advlist autolink lists link paste code'],
                                 toolbar:'pastetext | formatselect | forecolor | bold italic underline strikethrough removeformat | alignleft aligncenter alignright | bullist numlist blockquote | link unlink | code'
                               }"
              v-model="editTestimonial.review"
              :initial-value="editTestimonial.review"
              paste_as_text=true
            />
          </div>

          <hr>
          <div class="text-center p-3">
            <button type="submit" class="btn btn-primary">Edit Testimonial</button>
            <ConfirmButton text="Delete Testimonial" class="ml-3" @confirm="deleteTestimonial" />
          </div>
        </form>
      </template>
    </Modal>

  </div>

</template>

<script>
  import StarRating from 'vue-star-rating';
  import Editor from '@tinymce/tinymce-vue';

  export default {
    middleware: 'admin',
    layout: 'admin',
    name:'adminTestimonialsIndex',
    components: { StarRating,'editor': Editor },

    data() {
      return {
        items: {},
        loading:false,
        addTestimonialModal:false,
        addTestimonial:{},
        addTestimonialErrors:{},
        addTestimonialSuccess:false,
        editTestimonialModal:false,
        editTestimonial:{},
        editTestimonialErrors:{},
        editTestimonialSuccess:false,
        page:1,
        perPage: 12,
        totalRows:100,
      }
    },
    mounted() {
      this.getItems();
    },
    methods: {
      getItems() {
        let self=this;
        self.items={};
        axios.get('/api/testimonials?limit='+self.perPage+'&page='+(parseInt(self.page)-1)).then(function (res) {
          self.items=res.data.results;
          self.totalRows=res.data.total;
        })
      },
      toggleAddTestimonialModal() {
        let self=this;
        self.addTestimonial={};
        self.addTestimonialModal = !self.addTestimonialModal;
      },
      addTestimonialSubmit() {
        let self=this;
        self.loading=true;
        self.addTestimonialErrors={};
        axios.post('/api/testimonials',self.addTestimonial).then(function(res) {
          self.loading=false;
          self.addTestimonialModal=false;
          self.getItems();
          self.addTestimonialSuccess=true;
          setTimeout(function() {
            self.addTestimonialSuccess=false;
          },3000);
        }).catch(e=> {
          self.loading=false;
          console.log(e.response.data.message);
          self.addTestimonialErrors=e.response.data.errors;

        })
      },
      toggleEditTestimonialModal(id=null) {
        let self=this;
        self.editTestimonial={};
        self.editTestimonialModal = !self.editTestimonialModal;
        if(id) {
          axios.get('/api/testimonials/'+id).then(function(res) {
            self.editTestimonial=res.data;
          })
        }
      },
      editTestimonialSubmit() {
        let self=this;
        self.loading=true;
        self.editTestimonialErrors={};
        axios.post('/api/testimonials/'+self.editTestimonial.id,self.editTestimonial).then(function(res) {
          self.loading=false;
          self.editTestimonialModal=false;
          self.getItems();
          self.editTestimonialSuccess=true;
          setTimeout(function() {
            self.editTestimonialSuccess=false;
          },3000);
        }).catch(e=> {
          self.loading=false;
          console.log(e.response.data.message);
          self.editTestimonialErrors=e.response.data.errors;

        })
      },
      deleteTestimonial() {
        let self=this;
        axios.delete('/api/testimonials/'+self.editTestimonial.id).then(function(res) {
          self.toggleEditTestimonialModal();
          self.getItems();
        })
      }

    }
  }

</script>
