<template>
  <div id="AdminUsers">
    <div class="container pt-3 pb-3">

          <div class="row mb-2">
            <div class="col-auto">
              <h3>View User</h3>
            </div>
            <div class="ms-auto col-auto">
              <router-link to="/admin/users" class="btn btn-primary">Go Back</router-link>
            </div>
          </div>

          <b-tabs v-if="id"  card>
            <b-tab title="Details" active class="background-lighter">
              <UserDetails :id="parseInt(id)" class="card-body p-3"></UserDetails>
            </b-tab>
            <b-tab title="Logo" class="background-lighter">
              <UserLogo :id="parseInt(id)" class="card-body p-3"></UserLogo>
            </b-tab>
            <b-tab title="Orders" class="background-lighter">
              <UserOrders :id="parseInt(id)" class="card-body p-3"></UserOrders>
            </b-tab>
            <b-tab title="Prices" class="background-lighter">
              <UserPrices :id="parseInt(id)" class="card-body p-3"></UserPrices>
            </b-tab>
            <b-tab title="Invoices" class="background-lighter">
              <UserInvoices :id="parseInt(id)" class="card-body p-3"></UserInvoices>
            </b-tab>

          </b-tabs>

    </div>
  </div>
</template>

<script>

import UserDetails from './components/details'
import UserOrders from "./components/orders";
import UserPrices from "./components/prices";
import UserInvoices from "./components/invoices";
import UserLogo from "./components/logo";

export default {
  name:"admin.users.view",
  middleware: 'admin',

  components: {
    UserInvoices,
    UserPrices,
    UserOrders,
    UserDetails,
    UserLogo
  },

  metaInfo () {
    return { title: 'Admin Portal | '+window.config.appName}
  },

  data: () => ({
    loading:false,
    id:null
  }),

  mounted() {
    let self=this;
    self.id=parseInt(self.$route.params.id);
  }
}
</script>
