<template>
  <div id="AdminProjectPage" class="container-fluid">
    <div class="flex">
      <div class="flex-auto">
        <h1>Manage Projects</h1>
      </div>
      <div class="flex-none justify-end">
        <a hre="#" @click.prevent="toggleAddProjectModal" class="btn btn-primary">Add Item</a>
        <router-link to="/admin" class="btn btn-secondary ml-3">Go Back</router-link>
      </div>
    </div>


    <div class="card card-default mt-3">
      <div class="card-header">Manage Projects</div>
      <div v-if="Items" class="card-body">

        <draggable :list="Items" item-key="id" @change="sortEnd" class="grid grid-cols-4 gap-4" >
          <template #item="{element}">

            <div id="admin-item" class="admin-item">
              <div class="controls flex justify-between">
                <button type="button" class="justify-self-start"><i class="fa-solid fa-arrows-up-down-left-right"></i></button>
                <router-link :to="'/admin/projects/'+element.id" class="btn btn-sm justify-end">Edit</router-link>
              </div>

              <div class="item-image">
                <img v-if="element.image_url" :src="element.image_url" :alt="element.title"  />
                <img v-else src="/storage/images/loaders/loading-sm.svg" class="m-4" alt="Loading" />
              </div>
              <div class="title text-center">
                {{ element.title }}
              </div>
            </div>

          </template>

        </draggable>



      </div>
    </div>
    <div class="mt-3 justify-content-center d-flex text-center">
    </div>


    <Modal :show="addProjectModal" @close="toggleAddProjectModal" width="lg" title="Add Project">
      <template #body>
        <Loading v-if="loading" />
        <form v-else @submit.prevent="addProjectSubmit">

              <div class="mb-2">
                <label>Project Title</label>
                <input type="text" v-model="addProject.title" :class="{'error':(addProjectErrors.title)}" />
                <div class="form-error" v-if="addProjectErrors.title">{{ addProjectErrors.title[0] }}</div>
              </div>

          <hr>
          <div class="text-center p-3">
            <button type="submit" class="btn btn-primary">Add Project</button>
          </div>
        </form>
      </template>
    </Modal>



  </div>

</template>

<script>

  import draggable from 'vuedraggable';

  export default {
    middleware: 'admin',
    layout: 'admin',
    name:'adminProjectIndex',
    components: { draggable },

    data() {
      return {
        Items: null,
        loading:false,
        addProjectModal:false,
        addProject:{},
        addProjectErrors:{},
        Page:1,
        perPage: 24,
        totalRows:100,
      }
    },
    mounted() {
      this.getItems();
    },
    methods: {
      getItems() {
        let self=this;
        self.Items=null;
        axios.get('/api/projects?page='+(parseInt(self.Page)-1)).then(function (res) {
          self.Items=res.data.results;
          self.totalRows=res.data.total;
        })
      },
      toggleAddProjectModal() {
        let self=this;
        self.addProjectModal = !self.addProjectModal;
      },
      addProjectSubmit() {
        let self=this;
        self.loading=true;
        axios.post('/api/projects',self.addProject).then(function(res) {
          self.loading=false;
          self.addProjectModal=false;
          self.$router.push('/admin/projects/'+res.data.id);
        }).catch(e=> {
          self.loading=false;
          console.log(e.response.data.message);
          self.addProjectErrors=e.response.data.errors;

        })
      },
      sortEnd() {
        let self=this;
        axios.post('/api/projects/order',self.Items);
      },
    }
  }

</script>
