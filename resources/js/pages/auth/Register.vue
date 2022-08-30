<template>
  <div class=" flex flex-col sm:justify-center items-center pt-6 sm:pt-0">

    <teleport to="head">
      <title>The Picnic Hut | Create Account</title>
      <meta name="description" content="Create An Account" />
    </teleport>

    <div class="w-full sm:max-w-md  px-4 py-4">

    <Card title="Please Login Or Create An Account" class="mt-3 mb-3">
      <form @submit.prevent="register">
        <div>
          <label class="block font-medium text-sm text-gray-500" for="email">
            Firstname
          </label>
          <input v-model="data.firstname" class="p-2 rounded-md shadow-sm bg-white border border-gray-300 text-gray-400 block mt-1 w-full" id="name" type="text" name="name" required="required" autofocus="autofocus">
          <div v-if="errors && errors.firstname">
            <p v-for="(error, index) in errors.firstname" :key="'name-'+index" class="text-red-500">{{ error }}</p>
          </div>
        </div>
        <div>
          <label class="block font-medium text-sm text-gray-500" for="email">
            Lastname
          </label>
          <input v-model="data.lastname" class="p-2 rounded-md shadow-sm bg-white border border-gray-300 text-gray-400 block mt-1 w-full" id="name" type="text" name="name" required="required" autofocus="autofocus">
          <div v-if="errors && errors.lastname">
            <p v-for="(error, index) in errors.lastname" :key="'name-'+index" class="text-red-500">{{ error }}</p>
          </div>
        </div>
        <div class="mt-4">
          <label class="block font-medium text-sm text-gray-500" for="email">
            Email
          </label>
          <input v-model="data.email" class="p-2 rounded-md shadow-sm bg-white border border-gray-300 text-gray-400 block mt-1 w-full" id="email" type="email" name="email" required="required" autofocus="autofocus">
          <div v-if="errors && errors.email">
            <p v-for="(error, index) in errors.email" :key="'email-'+index" class="text-red-500">{{ error }}</p>
          </div>
        </div>
        <div class="mt-4">
          <label class="block font-medium text-sm text-gray-500" for="password">
            Password
          </label>
          <input v-model="data.password" class="p-2 rounded-md shadow-sm bg-white border border-gray-300 text-gray-400 focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50 block mt-1 w-full" id="password" type="password" name="password" required="required" autocomplete="current-password">
          <div v-if="errors && errors.password">
            <p v-for="(error, index) in errors.password" :key="'password-'+index" class="text-red-500">{{ error }}</p>
          </div>
        </div>
        <div class="mt-4">
          <label class="block font-medium text-sm text-gray-500" for="password">
            Repeat Password
          </label>
          <input v-model="data.password_confirmation" class="p-2 rounded-md shadow-sm bg-white border border-gray-300 text-gray-400 focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50 block mt-1 w-full" id="password_confirmation" type="password" name="password_confirmation" required="required" autocomplete="current-password">
          <div v-if="errors && errors.password_confirmation">
            <p v-for="(error, index) in errors.password_confirmation" :key="'password_confirmation-'+index" class="text-red-500">{{ error }}</p>
          </div>
        </div>
        <div class="flex items-center justify-end mt-4">
          <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white  tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-3">
            Register
          </button>
        </div>
      </form>

    </Card>
  </div>
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
        password_confirmation: null,
      },
      errors: null,
    }
  },

  methods: {
    register() {
      this.errors = null
      axios.get('/sanctum/csrf-cookie').then(response => {
        axios.post('/register', this.data)
          .then((response) => {
            this.$store.dispatch('attempt_user')
              .then(() => {
                this.$router.push({name: 'Home'})
              })
          })
          .catch((error) => {
            this.errors = error.response.data.errors
          })
      });
    }
  }
}
</script>
