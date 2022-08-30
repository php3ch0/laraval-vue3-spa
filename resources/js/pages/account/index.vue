<template>
  <div id="AccountPage">

    <teleport to="head">
      <title>Account | Manage Your Account</title>
      <meta name="description" content="Manage Your Account" />
    </teleport>

  <HeaderImage widget="accounttitle" title="Admin Page" imageurl="/storage/images/headers/event-catering.jpg" />

  <div class="mt-4 mb-4">
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
