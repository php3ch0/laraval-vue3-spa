<template>
  <div id="AccountPage">

    <teleport to="head">
      <title>Account | Manage Your Account</title>
      <meta name="description" content="Manage Your Account" />
    </teleport>

  <div class="mt-4 mb-4 pt-4 pb-4">
      <div class="container mx-auto">
        <div class="flex gap-4">
          <div class="flex-none xl:w-[250px]">
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
