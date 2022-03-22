<template>
  <div id="AdminDashboard">
    <div class="container pt-3 pb-3">

          <card title="Admin Dashboard">
            <div class="ps-3 pe-3">
              <div class="row">

                <DashIcon image="createjob.png" name="Users" url="/admin/users" description="Update and manage user accounts" />
                <DashIcon image="createjob.png" name="Products" url="/admin/products" description="Update and manage products" />
                <DashIcon image="createjob.png" name="Stock" url="/admin/stock" description="View and manage stock and stock prices" />
                <DashIcon image="createjob.png" name="Orders" url="/admin/orders" description="View and manage orders" />
                <DashIcon image="createjob.png" name="Shipping" url="/admin/delivery" description="Update Shipping Information" />
                <DashIcon image="createjob.png" name="Batches" url="/admin/batches" description="View Download and Process Batches" />
                <DashIcon image="createjob.png" name="Settings" url="/admin/settings" description="Change Settings" />
                <DashIcon image="createjob.png" name="Resolution Centre" url="/admin/tickets" description="View and Reply To Resolutions" />



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
