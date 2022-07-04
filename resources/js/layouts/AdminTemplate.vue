<template>
    <div id="AdminTemplate" class="container mx-auto">
         <div class="grid grid-cols-12 gap-4">
      <div class="col-span-2">
        <AdminMenu />
      </div>
      <div class="col-span-10">
        <router-view></router-view>
      </div>
    </div>
  </div>

</template>

<script>

import AdminMenu from "./components/AdminMenu";

export default {
  components: {
    AdminMenu,
  },
}
</script>
