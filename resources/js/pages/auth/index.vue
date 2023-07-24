<template>

  <div id="AuthPage" class="page-pad">

    <teleport to="head">
      <title>Whichcote Arms | Create Account</title>
      <meta name="description" content="Register an account on Whichcote Arms" />
    </teleport>



    <div class="container">
      <div class="max-w-2xl mx-auto">
        <div class="page-logo hidden lg:flex justify-center">
          <img src="/storage/images/logo_trans.png" class="mt-4 mb-4 max-h-[90px]" alt="Whichcote Arms" />
        </div>

        <router-view></router-view>
      </div>
    </div>

  </div>

</template>

<script>
export default {
  name: "auth.index"
}
</script>
