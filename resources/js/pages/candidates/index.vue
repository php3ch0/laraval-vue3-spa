<template>
  <div id="CandidatesPage">

    <teleport to="head">
      <title>Portside Film and Media Recruitment | Candidates</title>
      <meta name="description" content="Enable us to showcase you to our clients and to match you with a shortlist of suitable positions within the Film and Media Industry" />
    </teleport>

    <HeaderImage widget="candidatestitle" title="Portside Recruitment Candidates" imageurl="/storage/images/headers/candidates.jpg" />


    <div class="container">
      <div class="mb-4 mt-4 text-center">
        <Widget name="CandidatesText1" />
      </div>

      <div class="mb-4 mt-4 text-center">
        <Widget name="CandidatesText2" />
      </div>

      <div class="my-4 text-center grid grid-cols-1 lg:grid-cols-3 xl:grid-cols-6 gap-4">

        <div class="process-item arrow">
          <div class="image">
            <img src="/storage/images/icons/registration.png" alt="Registration" />
          </div>
          <div class="text">
            <Widget name="ProcessItem1Text" />
          </div>
        </div>

        <div class="process-item arrow">
          <div class="image">
            <img src="/storage/images/icons/costs.png" alt="Cost Agreements" />
          </div>
          <div class="text">
            <Widget name="ProcessItem2Text" />
          </div>
        </div>

        <div class="process-item arrow">
          <div class="image">
            <img src="/storage/images/icons/assessment.png" alt="Skills Assessment" />
          </div>
          <div class="text">
            <Widget name="ProcessItem3Text" />
          </div>
        </div>

        <div class="process-item arrow">
          <div class="image">
            <img src="/storage/images/icons/introductions.png" alt="Introductions" />
          </div>
          <div class="text">
            <Widget name="ProcessItem4Text" />
          </div>
        </div>

        <div class="process-item arrow">
          <div class="image">
            <img src="/storage/images/icons/rates.png" alt="Rates Agreement" />
          </div>
          <div class="text">
            <Widget name="ProcessItem5Text" />
          </div>
        </div>

        <div class="process-item">
          <div class="image">
            <img src="/storage/images/icons/contract.png" alt="Work Contract" />
          </div>
          <div class="text">
            <Widget name="ProcessItem6Text" />
          </div>
        </div>

      </div>

    </div>
  </div>

  <div class="container text-center">
    <router-link to="/register" class="btn btn-lg btn-primary"  style="margin-bottom:80px;">Register Now</router-link>
  </div>

  <div class="container text-center mx-4 px-4">
    <Widget name="CandidatesText3" />
  </div>





</template>

<script>



export default {
  name: "CandidatesPage",

}
</script>
