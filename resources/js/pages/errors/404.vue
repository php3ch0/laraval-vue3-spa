<template>
  <div id="SendPasswordPage" class="d-flex">
    <div class="container align-self-center pt-3 pb-3">
      <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
          <card class="text-center">
            <h3 class="mb-4">
              Error 404
            </h3>
            <p>Page Not Found</p>

            <div class="links">
              <router-link to="/" class="btn btn-primary">
                Return Home
              </router-link>
            </div>
          </card>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  layout:'plain',
  name: 'NotFound'
}
</script>
