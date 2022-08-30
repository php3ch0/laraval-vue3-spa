<template>
    <div id="PrivacyPage">
      <teleport to="head">
        <title>The Picnic Hut | Privacy Policy</title>
        <meta name="description" content="Information about how we collect data about your visit to our web site and how we use this data." />
      </teleport>

      <div class="container">
        <div class="white-box mt-3 mb-3">
          <Widget name="PrivacyPolicy" />
        </div>

      </div>
    </div>
</template>

<script>

export default {
  name: "PrivacyPolicy",

}
</script>
