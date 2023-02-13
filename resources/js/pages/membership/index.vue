<template>
  <div id="MembershipPage">

    <teleport to="head">
      <title>Portside Film and Media Recruitment | Membership</title>
      <meta name="description" content="We offer dedicated membership benefits for both candidate and freelance candidates. Membership benefits for candidates, placed candidates and freelancers are included in the monthly fee" />
    </teleport>

    <HeaderImage widget="membershiptitle" title="Portside Recruitment Membership" imageurl="/storage/images/headers/membership.jpg" />


    <div class="container">
      <div class="mb-4 mt-4 text-center">
        <Widget name="MembershipText1" />
      </div>


      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="membership-list">
          <Widget name="MembershipList1" />
        </div>
        <div class="membership-list">
          <Widget name="MembershipList2" />
        </div>
      </div>

    </div>

    <div class="container text-center">
      <router-link to="/register" class="btn btn-lg btn-primary"  style="margin:80px 0;">Register Now</router-link>
    </div>

  </div>



</template>

<script>



export default {
  name: "MembershipPage",

}
</script>
