<template>
  <div id="LoginPage">
    <div class="container pt-3 pb-3">

          <card title="Dashboard">
            <div class="row justify-content-center">

            </div>




          </card>

    </div>
  </div>
</template>

<script>



export default {

  middleware: 'auth',

  data: () => ({
    searchTerm:null,


  }),

  metaInfo () {
    return { title: ''}
  },

}
</script>
