<template>
  <div id="AdminTestimonials" class="container-fluid">
    <div class="row">
      <div class="col-6">
        <h1>Manage Testimonials</h1>
      </div>

      <div class="col-12 col-lg-6 text-end">
          <router-link to="/admin" class="btn btn-primary">Go Back </router-link>
          <button class="btn btn-primary" @click="$bvModal.show('add-modal')">Add Testimonial</button>

      </div>

    </div>

    <card title="Manage Testimonials" class="mt-3">
      <div v-if="Message">
        <div class="alert alert-success">{{ Message }}</div>
      </div>
      <LoadingSm v-if="Loading"  />
      <div v-else>

        <div v-if="testimonials">
          <table class="table">
            <thead>
            <tr>
              <th style="width:40px;"></th>
              <th>Name</th>
              <th style="width:140px;"></th>
            </tr>
            </thead>

            <draggable v-model="testimonials" element="tbody" handle=".handle" @start="drag=true" @end="onSortEnd()">
            <tr v-for="t in testimonials" :key="t.id">
              <td><i class="fas fa-arrows-alt handle"></i></td>
              <td>{{ t.name }}</td>
              <td class="text-end">
                <router-link :to="'/admin/testimonials/'+t.id" class="btn btn-primary">Edit</router-link>
              </td>
            </tr>
            </draggable>

          </table>
        </div>

      </div>

    </card>


    <b-modal id="add-modal" hide-footer>
      <template v-slot:modal-title>
        Add Testimonial
      </template>
      <div class="d-block">
        <div class="mb-2">
          <label>Name</label>
          <p>Once you have entered a name please click on save to add job title and text</p>
          <b-form-input v-model="testimonial.name" required :autofocus="true"></b-form-input>
          <div v-if="Errors" class="error">You have not entered a name</div>
        </div>
      </div>
      <b-button class="btn btn-primary mt-3" @click="addTestimonial">Add Testimonial</b-button>
      <b-button class="btn btn-secondary mt-3" @click="$bvModal.hide('add-modal')">Close</b-button>
    </b-modal>




  </div>

</template>

<script>

import draggable from 'vuedraggable';
import LoadingSm from "../../../components/LoadingSm";

export default {
  middleware: 'admin',
  layout: 'admin',
    name: 'AdminTestimonials',

  metaInfo () {
    return { title: 'Admin | Testimonials' }
  },
  components: {
    LoadingSm,
    draggable
  },
    data() {
        return {
            Message:null,
            Loading:true,
            testimonials:{},
            testimonial:{},
            Errors:false,
        }
    },
    mounted() {
        this.getTestimonials();
    },
    methods: {
      getTestimonials() {
        let self = this;
        self.Loading=true;
        self.testimonials={};
        self.$axios.get('/api/testimonials').then(function (res) {
          self.testimonials = res.data;
          self.Loading=false;
        });
      },

      addTestimonial() {
          let self=this;
          self.Errors=null;
          self.$axios.post('/api/testimonials',self.testimonial).then(function (res) {
            self.$router.push('/admin/testimonials/'+res.data.id);
          }).catch((error) => {
            self.Loading=false;
            self.Errors = error.response.data;
          });
      },
      onSortEnd() {
        let self = this;
        self.$axios.post('/api/testimonials/order',this.testimonials).then(function(res) {
          self.getTestimonials();
        });
      }
    }
}
</script>
