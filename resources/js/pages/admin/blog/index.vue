<template>
  <div id="AdminBlogPage" class="container-fluid">
    <div class="flex">
      <div class="flex-auto">
        <h1>Manage Blogs</h1>
      </div>
      <div class="flex-none justify-end">
        <a href="#" @click.prevent="toggleAddBlogModal" class="btn btn-primary">Add Item</a>
        <router-link to="/admin" class="btn btn-secondary ml-3">Go Back</router-link>
      </div>
    </div>


    <div class="card card-default mt-3">
      <div class="card-header">Manage Blogs</div>
      <div class="card-body">

        <div class="grid grid-cols-3 gap-4">
          <div v-for="Item in Items" :key="Item.id">
            <item :item="Item"></item>
          </div>
        </div>

      </div>
    </div>
    <div v-if="Items && Items.length" class="mt-3 justify-content-center d-flex text-center">
      <pagination v-model="currentPage" :records="totalRows" :per-page="perPage" @paginate="getItems"/>
    </div>


    <Modal :show="addBlogModal" @close="toggleAddBlogModal" width="lg" title="Add Blog">
      <template #body>
        <Loading v-if="loading" />
        <form v-else @submit.prevent="addBlogSubmit">

              <div class="mb-2">
                <label>Blog Title</label>
                <input type="text" v-model="addBlog.title" :class="{'error':(addBlogErrors.title)}" />
                <div class="form-error" v-if="addBlogErrors.title">{{ addBlogErrors.title[0] }}</div>
              </div>

          <hr>
          <div class="text-center p-3">
            <button type="submit" class="btn btn-primary">Add Blog</button>
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
    name:'adminBlogIndex',
    components: { Item },

    data() {
      return {
        Items: {},
        loading:false,
        addBlogModal:false,
        addBlog:{},
        addBlogErrors:{},
        currentPage:1,
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
        self.Items={};
        axios.get('/api/blog?page='+self.currentPage+'&limit='+self.perPage).then(function (res) {
          self.Items=res.data.data;
          self.totalRows=res.data.total;
        })
      },
      toggleAddBlogModal() {
        let self=this;
        self.addBlogModal = !self.addBlogModal;
      },
      addBlogSubmit() {
        let self=this;
        self.loading=true;
        axios.post('/api/blog',self.addBlog).then(function(res) {
          self.loading=false;
          self.addBlogModal=false;
          self.$router.push('/admin/blog/'+res.data.id);
        }).catch(e=> {
          self.loading=false;
          console.log(e.response.data.message);
          self.addBlogErrors=e.response.data.errors;

        })
      }
    }
  }

</script>
