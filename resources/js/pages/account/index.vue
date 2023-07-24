<template>
  <div id="AccountPage" class="page-pad">

    <HeaderImageSmall title="Account" />

  <div class="mt-4 mb-4 pt-4 pb-4">
      <div class="container mx-auto">
        <div class="lg:flex gap-4">
          <div class="flex-none xl:w-[250px] mb-4">
            <AccountMenu />
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
import AccountMenu from "./components/AccountMenu";

export default {
  name: "AccountPage",
  components: {AccountMenu}
}
</script>
