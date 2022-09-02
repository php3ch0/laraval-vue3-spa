<template>
  <nav id="AdminMenu" class="bg-white border-b border-gray-200 p-4 mb-4">
    <div class="mb-2"><h4 class="font-bold text-black border-b-[2px]">ADMIN MENU</h4></div>
    <ul>
      <li><router-link to="/admin">Dashbord</router-link></li>
      <li><router-link to="/admin/orders">Orders</router-link></li>
      <li><router-link to="/admin/products">Products</router-link></li>
      <li><router-link to="/admin/users">Users</router-link></li>
    </ul>
  </nav>
</template>

<script>
export default {

}
</script>
