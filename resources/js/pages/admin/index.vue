<template>
    <div id="AdminPage" class="mt-4 mb-4">
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
</template>

<script>
import AdminMenu from "./components/AdminMenu";
export default {
  name: "AdminPage",
  components: {AdminMenu}
}
</script>
