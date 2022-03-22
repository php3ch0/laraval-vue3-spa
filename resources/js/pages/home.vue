<template>
  <div id="LoginPage">
    <div class="container pt-3 pb-3">

          <card title="Dashboard">
            <div class="row justify-content-center">
              <HomeIcon image="pending.png" name="Pending" url="/orders?status=live" :count="counts.live" color="blue" />
              <HomeIcon image="production.png" name="Production" url="/orders?status=printing" :count="counts.printing" color="orange" />
              <HomeIcon image="issues.png" name="Issue Jobs" url="/orders?status=problem" :count="counts.problem" color="red" />
              <HomeIcon image="dispatched.png" name="Dispatched" url="/orders?status=dispatched" :count="counts.dispatched" color="green" />
            </div>

            <div class="row mt-3 mb-3 justify-content-center">
              <div class="col-12 col-lg-4">
                <card title="Search Order">
                  <form @submit.prevent="searchOrder">
                    <div class="input-group">
                      <input v-model="searchTerm" class="form-control" />
                      <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Search</button>
                      </div>
                    </div>
                  </form>
                </card>
              </div>

            </div>


          </card>

    </div>
  </div>
</template>

<script>

import DashIcon from "../components/DashIcon";
import HomeIcon from "../components/HomeIcon";

export default {
  components: {DashIcon,HomeIcon},
  middleware: 'auth',

  data: () => ({
    searchTerm:null,
    counts:{
      live:0,
      problem:0,
      printing:0,
      dispatched:0,
    }

  }),

  metaInfo () {
    return { title: 'Print Junction System'}
  },
  mounted() {
    this.countOrders();
  },
  methods: {
    countOrders() {
      let self=this;
      self.$axios.get('/api/user/countorders').then(function(res) {
        self.counts=res.data;
      })
    },
    searchOrder() {
      let self=this;
      self.$router.push('/orders?term='+self.searchTerm);
    }
  }
}
</script>
