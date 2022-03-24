<template>

  <div id="AdminServices">
    <div class="row">
      <div class="col">
        <h1>Manage Services</h1>
      </div>


      <div class="col-auto">
        <router-link to="/admin/services/add" class="btn btn-primary ml-3">Add Service</router-link>

      </div>

      </div>




    <draggable v-model="Services" element="div" @start="drag=true" @end="onSortEnd()" class="row mt-3">
      <div v-for="Service in Services" class="col-12 col-sm-6 col-md-4 col-lg-3" :ref="'item'+Service.id" :key="Service.order_by">
        <router-link :to="'/admin/services/'+Service.id">
          <div class="admin-service">
            <i class="fas fa-expand-arrows-alt" title="Change Order By Drag and Drop"></i>
            <div class="image">
              <img :src="Service.image_icon_url" :alt="Service.name" />
            </div>
            <div class="name">
              <h5>{{ Service.name }}</h5>
            </div>

          </div>
        </router-link>
      </div>
    </draggable>

  </div>

</template>

<script>
    import draggable from 'vuedraggable'

    export default {
        name: "AdminServices",
        middleware: 'admin',
        layout:'admin',
        components: {
            draggable,
        },
        data () { return {
            Services:null,
        }},
        mounted() {
            this.getServices();
        },
        watch: {
          type: function() {
            this.getServices();
          }
        },
        methods: {
            getServices() {
                let self=this;
                self.Services={};
                self.$axios.get('/api/services').then(function (res) {
                    self.Services=res.data.results;
                })
            },
            onSortEnd() {
                let self = this;
                self.$axios.post('/api/services/order',self.Services);
            }
        }

    }
</script>

<style lang="scss" scoped>
  .admin-service {
    margin:10px;
    border:1px solid #CCC;
    position: relative;
    &:hover {
      border:1px solid #000;
    }
    i {
      position: absolute;
      top:10px;
      left:10px;
      z-index: 20;
      font-size: 1.4em;
    }
    .image {
      padding:10px;
      height:220px;
      width:100%;
      justify-content: center;
      text-align: center;

      img {
        align-self:center;
        max-width: 100%;
        max-height:200px;
      }
    }
    .name {
      margin-top:10px;
      height:80px;
      text-align: center;
    }
  }
</style>
