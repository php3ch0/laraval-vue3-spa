<template>
    <div id="CookiesPage">
      <teleport to="head">
        <title>The Picnic Hut | Cookie Policy</title>
        <meta name="description" content="Information about cookies and how we use the information stored about your visit" />
      </teleport>

      <div class="container">
        <div class="white-box mt-3 mb-3">
          <Widget name="Cookies" />
        </div>

      </div>
    </div>
</template>

<script>
export default {
  name: "Terms",

}
</script>
