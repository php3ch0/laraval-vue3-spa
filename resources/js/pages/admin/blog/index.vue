<template>
  <div id="AdminBlogPage" class="container-fluid">
    <div class="row">
      <div class="col-12 col-lg-8">
        <h1>Manage Blog</h1>
      </div>
      <div class="col-12 col-lg-4 text-end">
        <router-link to="/admin/blog/add" class="btn btn-primary">Add Item</router-link>
        <router-link to="/admin" class="btn btn-secondary">Go Back</router-link>
      </div>
    </div>


    <div class="card card-default mt-3">
      <div class="card-header">Manage Blog</div>
      <div class="card-body">

        <div class="row">
          <div v-for="Item in Items" class="col-12 col-md-6 col-lg-3" :key="Item.id">
            <item :id="Item.id"></item>
          </div>
        </div>

      </div>
    </div>
    <div class="mt-3 justify-content-center d-flex text-center">
    <b-pagination size="md" :total-rows="totalRows" v-model="Page" :per-page="perPage" @input="getItems(Page)">
    </b-pagination>
    </div>


  </div>

</template>

<script>
  import Item from './components/item';
  let VueScrollTo = require('vue-scrollto');

  export default {
    middleware: 'admin',
    layout: 'admin',
    name:'adminBlogIndex',
    components: { Item },

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
        Items: {},
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
        self.$axios.get('/api/blog?page='+(parseInt(self.Page)-1)).then(function (res) {
          self.Items=res.data.posts;
          self.totalRows=res.data.total;

          VueScrollTo.scrollTo('#AdminBlogPage',{
            container: 'body',
            easing: 'ease-in',
            offset: 0,
            force: true,
            cancelable: true}
          );
        })
      }
    }
  }

</script>
