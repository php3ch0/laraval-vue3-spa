<template>
  <div id="AccountPage">

    <HeaderImage title="Account" imageurl="/storage/images/headers/account.jpg" />

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
import HeaderImage from "../../components/HeaderImage";
export default {
  name: "AccountPage",
  components: {HeaderImage, AccountMenu}
}
</script>
