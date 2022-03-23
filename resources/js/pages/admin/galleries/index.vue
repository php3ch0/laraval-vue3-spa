<template>
  <div >
    <div class="row">
      <div class="col-12 col-lg-8">
        <h1>Manage Galleries</h1>
      </div>
      <div class="col-12 col-lg-4 text-end">
        <button @click.prevent="$bvModal.show('add-modal')" class="btn btn-primary">Add Item</button>
      </div>
    </div>


    <div class="card card-default mt-3">
      <div class="card-header">Manage Galleries</div>
      <div class="card-body">
        <table class="table">
          <tr v-for="Gallery in items">
            <td style="width:30px;">{{ Gallery.id }}</td>
            <td>{{ Gallery.name }}</td>
            <td class="text-end"><router-link :to="'/admin/galleries/'+ Gallery.id" class="btn btn-primary">Edit</router-link></td>

          </tr>
        </table>
      </div>
    </div>


    <b-modal id="add-modal" hide-footer>
      <template v-slot:modal-title>
        Add Gallery
      </template>
      <div class="d-block">
        <div class="mb-2">
          <label>Name</label>
          <b-form-input v-model="tmpItem.name" required></b-form-input>
          <div v-if="addError" class="error">This cannot be empty</div>
        </div>
      </div>
      <b-button class="btn btn-primary mt-3" @click="addItem">Add Item</b-button>
      <b-button class="btn btn-secondary mt-3" @click="$bvModal.hide('add-modal')">Close</b-button>
    </b-modal>



  </div>

</template>

<script>

  import Swal from 'sweetalert2';

  export default {
    middleware: 'admin',
    layout: 'admin',
    name:'adminGalleriesIndex',

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
        items: {},
        tmpItem:{},
        addError:null,
        Page:0,
      }
    },
    mounted() {
      let self=this;
      self.getItems();
    },
    methods: {

      getItems() {
        let self=this;
        self.items={};
        self.$axios.get('/api/galleries?hidden=true').then(function (res) {
          self.items=res.data.results;
        }).catch(error => {
          console.log(error.response.data.status);
          Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Error: '+error.response.data.status
          })
        });
      },
      addItem() {
        let self=this;
        self.addError=false;
        self.$axios.post('/api/galleries',self.tmpItem).then(function (res) {
          self.tmpItem={};
          self.$bvModal.hide('add-modal');
          self.$router.push('/admin/galleries/'+res.data.results.id);
        }).catch(error => {
          self.addError = error.response.data;
        });
      },
    }

  }

</script>
