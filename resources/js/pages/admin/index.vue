<template>
  <div id="AdminDashboard">
    <div class="container pt-3 pb-3">

          <card title="Admin Dashboard">
            <div class="ps-3 pe-3">
              <div class="row">



              </div>
            </div>


          </card>

    </div>
  </div>
</template>

<script>



export default {
  name:"admin.index",
  middleware: 'admin',

  metaInfo () {
    return { title: 'Admin Portal | '+window.config.appName}
  },


}
</script>
