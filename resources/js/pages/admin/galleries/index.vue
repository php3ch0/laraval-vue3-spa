<template>
  <div id="AdminGalleriesPage" class="container-fluid">
    <div class="flex">
      <div class="flex-auto">
        <h1>Manage Galleries</h1>
      </div>
      <div class="flex-none justify-end">
        <a href="#" @click.prevent="toggleAddGalleryModal" class="btn btn-primary">Add Gallery</a>
        <router-link to="/admin" class="btn btn-secondary ml-3">Go Back</router-link>
      </div>
    </div>


    <div class="card card-default mt-3">
      <div class="card-header">Manage Galleries</div>
      <div class="card-body">

        <div class="grid grid-cols-3 gap-4">
          <div v-for="Item in items" :key="Item.id">
            <Item :item="Item"></Item>
          </div>
        </div>

      </div>
    </div>
    <div class="mt-3 justify-content-center d-flex text-center">
      <pagination v-model="page" :records="totalRows" :per-page="perPage" @paginate="getItems"/>
    </div>


    <Modal :show="addGalleryModal" @close="toggleAddGalleryModal" width="lg" title="Add Gallery">
      <template #body>
        <Loading v-if="loading" />
        <form v-else @submit.prevent="addGallerySubmit">

              <div class="mb-2">
                <label>Gallery Name</label>
                <input type="text" v-model="addGallery.name" :class="{'error':(addGalleryErrors.name)}" />
                <div class="form-error" v-if="addGalleryErrors.name">{{ addGalleryErrors.name[0] }}</div>
              </div>

          <hr>
          <div class="text-center p-3">
            <button type="submit" class="btn btn-primary">Add Gallery</button>
          </div>
        </form>
      </template>
    </Modal>



  </div>

</template>

<script>
  import Item from './components/item';


  export default {
    middleware: 'admin',
    layout: 'admin',
    name:'adminGalleryIndex',
    components: { Item },

    data() {
      return {
        items: {},
        loading:false,
        addGalleryModal:false,
        addGallery:{},
        addGalleryErrors:{},
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
        axios.get('/api/galleries?limit='+self.perPage+'&page='+(parseInt(self.page)-1)).then(function (res) {
          self.items=res.data.results;
          self.totalRows=res.data.total;
        })
      },
      toggleAddGalleryModal() {
        let self=this;
        self.addGallery={};
        self.addGalleryModal = !self.addGalleryModal;
      },
      addGallerySubmit() {
        let self=this;
        self.loading=true;
        self.addGalleryErrors={};
        axios.post('/api/galleries',self.addGallery).then(function(res) {
          self.loading=false;
          self.addGalleryModal=false;
          self.$router.push('/admin/galleries/'+res.data.id);
        }).catch(e=> {
          self.loading=false;
          console.log(e.response.data.message);
          self.addGalleryErrors=e.response.data.errors;

        })
      }
    }
  }

</script>
