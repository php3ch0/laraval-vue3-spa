<template>
    <div id="AdminWidgetsPage" class="container-fluid">
        <div class="flex justify-end">
            <div class="flex-auto">
                <h1>Edit Widgets</h1>
            </div>
            <div class="justify-self-end flex-none">

                <button class="btn btn-secondary ml-4" @click.prevent="toggleAddWidgetModal"><i class="fas fa-plus"></i> Widget</button>
                <router-link class="btn btn-secondary ml-4" to="/admin"><i class="fa-solid fa-circle-arrow-left"></i> Admin</router-link>
            </div>
        </div>
        <Card title="Manage Widgets">

          <Loading v-if="loading" />
            <div v-else class="grid grid-cols-3 gap-4">
                <div v-for="w in items" class="border-[1px] mb-2 border-grey-500 p-3 hover:bg-slate-200">
                    <router-link :to="'/admin/widgets/'+w.id" class="block">
                        <i v-if="w.type==='TEXT'" class="fa-solid fa-align-left mr-3"></i>
                        <i v-else class="fa-solid fa-image mr-3"></i>
                        {{ w.name }}
                    </router-link>
                </div>
            </div>



        </Card>


      <Modal :show="addWidgetModal" @close="toggleAddWidgetModal" width="lg" title="Add Widget">
        <template #body>
          <Loading v-if="addWidgetLoading" />
          <form v-else @submit.prevent="addWidgetSubmit">
                    <div class="mb-2">
                        <label>Widget Name</label>
                        <input type="text" v-model="addWidget.name" />
                        <div v-if="addWidgetErrors.name" class="form-error">{{ addWidgetErrors.name }}</div>
                    </div>
                    <button type="submit" class="btn">Save Changes</button>
                </form>
            </template>
        </Modal>



    </div>
</template>

<script>
import Loading from "../../../components/Loading";
export default {

  name: 'AdminWidgetsIndex',
  components: {Loading},
  data() {
    return {
      items: {},
      addWidget:{},
      addWidgetErrors:{},
      addWidgetLoading:false,
      addWidgetModal:false,
      loading:false
    }
  },

  mounted() {
    let self=this;
    self.getWidgets();
  },

  methods: {
    getWidgets() {
      let self=this;
      self.loading=true;
      axios.get('/api/widgets').then(function(res) {
        self.items=res.data;
        self.loading=false;
      }).catch(e=>{
        console.log(e.response.data);
      })
    },
    toggleAddWidgetModal() {
      let self=this;
      self.addWidget={};
      self.addWidgetModal = !self.addWidgetModal;
    },
    addWidgetSubmit() {
      let self=this;
      self.addWidgetLoading=true;
      self.addWidgetErrors={};
      self.addWidget.type='TEXT';
      axios.post('/api/widgets',self.addWidget).then(function(res) {
        self.addWidgetLoading=false;
        self.addWidgetModal=false;
        self.getWidgets();
      }).catch(e=>{
        self.addWidgetLoading=false;
        self.addWidgetErrors=e.response.data;
      })
    }
  }

}
</script>
