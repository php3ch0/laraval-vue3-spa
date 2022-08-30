<template>
  <div id="AdminPage">

    <teleport to="head">
      <title>Admin | Manage Your Website</title>
      <meta name="description" content="Manage Your Website" />
    </teleport>

    <HeaderImage widget="accounttitle" title="Admin Page" imageurl="/storage/images/headers/event-catering.jpg" />
    <div  class="mt-4 mb-4">

      <div class="container mx-auto">
        <div class="flex gap-4">
          <div class="flex-none xl:w-[250px]">
            <AdminMenu />
          </div>
          <div class="flex-auto">
            <div class="white-box">
              <router-view />
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>

</template>

<script>
import AdminMenu from "./components/AdminMenu";
export default {
  name: "AdminPage",
  components: {AdminMenu}
}
</script>
