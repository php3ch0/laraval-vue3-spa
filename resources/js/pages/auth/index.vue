<template>

  <div id="AuthPage" class="page-bg">

    <teleport to="head">
      <title>Portside Film and Media Recruitment | Create Account</title>
      <meta name="description" content="Register an account on Portside Film and Media Recruitment" />
    </teleport>



    <div class="container">
      <div class="max-w-2xl mx-auto">
        <div class="page-logo hidden lg:block">
          <img src="/storage/images/logo_border.png" class="mt-4 mb-4" alt="Portside Film and Media Recruitment" />
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
