<template>
  <div id="AdminBlogPage" class="container-fluid">
    <div class="flex">
      <div class="flex-auto">
        <h1>Manage Blog</h1>
      </div>
      <div class="flex-none justify-end">
        <a hre="#" @click.prevent="toggleAddBlogModal" class="btn btn-primary">Add Item</a>
        <router-link to="/admin" class="btn btn-secondary ml-3">Go Back</router-link>
      </div>
    </div>


    <div class="card card-default mt-3">
      <div class="card-header">Manage Blog</div>
      <div class="card-body">

        <div class="grid grid-cols-3 gap-4">
          <div v-for="Item in Items" :key="Item.id">
            <item :item="Item"></item>
          </div>
        </div>

      </div>
    </div>
    <div class="mt-3 justify-content-center d-flex text-center">
    <b-pagination size="md" :total-rows="totalRows" v-model="Page" :per-page="perPage" @input="getItems(Page)">
    </b-pagination>
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
        self.Items={};
        axios.get('/api/blog?page='+(parseInt(self.Page)-1)).then(function (res) {
          self.Items=res.data.posts;
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
