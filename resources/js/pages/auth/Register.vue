<template>
  <div id="RegisterPage">
          <Card title="Register" class="mt-3 mb-3">

            <div class="mt-3 mb-3 alert alert-danger" v-if="errors && Object.keys(errors).length">
              Some of your information is invalid please check and re-submit
            </div>

            <form @submit.prevent="register">
              <div class="grid grid-cols-1 gap-4">

                <div class="col">
                  <div class="form-group mb-2">
                    <label>First name</label>
                    <input v-model="data.firstname" class="form-control" type="text" name="firstname" />
                    <div v-if="errors && errors.firstname" class="form-error">{{ errors.firstname[0]}}</div>
                  </div>
                  <div class="form-group mb-2">
                    <label>Last name</label>
                    <input v-model="data.lastname" class="form-control" type="text" name="lastname" />
                    <div v-if="errors && errors.lastname" class="form-error">{{ errors.lastname[0]}}</div>
                  </div>
                  <div class="form-group mb-2">
                    <label>Email Address</label>
                    <input v-model="data.email" class="form-control" type="text" name="email" />
                    <div v-if="errors && errors.email" class="form-error">{{ errors.email[0]}}</div>
                  </div>

                  <div class="form-group mb-2">
                    <label>Password</label>
                    <input v-model="data.password" class="form-control" type="password" />
                    <div v-if="errors && errors.password" class="form-error">{{ errors.password[0]}}</div>
                  </div>
                  <div class="form-group mb-2">
                    <label>Confirm Password</label>
                    <input v-model="data.password_confirmation" class="form-control" type="password" />
                    <div v-if="errors && errors.password_confirmation" class="form-error">{{ errors.password_confirmation[0]}}</div>
                  </div>
                  <div class="my-3 text-center">
                    <small>By signing Up you are agreeing to our terms and conditions and privacy policy</small>
                  </div>

                  <div class="my-3 text-center">
                    <button type="submit" class="btn btn-primary">Register</button>
                  </div>
                </div>

              </div>


            </form>

          </Card>
  </div>



</template>

<script>

export default {
  data: () => {
    return {
      data: {
        firstname: null,
        lastname: null,
        email: null,
        password: null,
        password_confirmation: null
      },
      errors:{},

    }
  },

  methods: {


    register() {
      let self=this;
      self.errors = {};
      axios.get('/sanctum/csrf-cookie').then(response => {

        let formData = new FormData();
        var arr = self.data;

        for (let key in arr) {
          Array.isArray(arr[key])
            ? arr[key].forEach(value => formData.append(key + '[]', value))
            : formData.append(key, arr[key]) ;
        }


        axios.post('/api/register', formData,
          { headers: {'Content-Type': 'multipart/form-data'}})
          .then((response) => {
            this.$store.dispatch('attempt_user')
              .then(() => {
                this.$router.push({name: 'Account'})
              })
          })
          .catch((error) => {
            if(error.response.status===413) {
              self.errors.cvfile=['The file you have uploaded is too large. Max 12MB'];
              self.step=2;
            } else {
              self.step=1;
              self.errors = error.response.data
            }

          })
      });
    }
  }
}
</script>
