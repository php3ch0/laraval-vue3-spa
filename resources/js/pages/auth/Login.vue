<template>
  <div class="flex flex-col justify-center items-center pt-6 sm:pt-0 p-4">

    <teleport to="head">
      <title>The Picnic Hut | Login</title>
      <meta name="description" content="Login to your Picnic Hut Account" />
    </teleport>


    <div class="w-full sm:max-w-md mt-6 px-4 py-4">
      <Card title="Please Login Or Create An Account">
      <form @submit.prevent="login">
        <div>
          <label class="block font-medium text-sm text-gray-500" for="email">
            Email
          </label>
          <input v-model="data.email" class="p-2 rounded-md shadow-sm bg-white border border-gray-300 text-gray-400 block mt-1 w-full" id="email" type="email" name="email" required="required" autofocus="autofocus">
        </div>
        <div class="mt-4">
          <label class="block font-medium text-sm text-gray-500" for="password">
            Password
          </label>
          <input v-model="data.password" class="p-2 rounded-md shadow-sm bg-white border border-gray-300 text-gray-400 focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50 block mt-1 w-full" id="password" type="password" name="password" required="required" autocomplete="current-password">
        </div>
        <div v-if="errors" class="text-red-500 py-2 font-semibold">
          <span>{{ errors.message }}</span>
        </div>
        <div class="block mt-4">
          <label for="remember" class="inline-flex items-center">
            <input v-model="data.remember" id="remember" type="checkbox" class="flex-none rounded border border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" style="width:auto;" name="remember">
            <span class="ml-2 text-sm text-gray-500">Remember me</span>
          </label>
        </div>
        <div class="flex items-center mt-4 mb-4">
          <router-link class="underline text-sm text-gray-500 hover:text-gray-200 flex-auto" :to="{name: 'ForgotPassword'}">
            Forgot your password?
          </router-link>
          <div class="justify-end">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white  tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-3">
              Log in
            </button>
          </div>

        </div>
      </form>
        <hr>
        <div class="text-center text-sm mt-4">
          Don't have an account yet?
          <router-link class="underline text-gray-500 hover:text-gray-200" :to="{name: 'Register'}">
            Sign up now
          </router-link>
        </div>

      </Card>
    </div>

  </div>
</template>

<script>


export default {
  data: () => {
    return {
      errors: null,
      data: {
        email: null,
        password: null,
        remember: null,
      },
    }
  },

  methods: {
    login() {
      this.errors = null
      axios.get('/sanctum/csrf-cookie').then(response => {
        axios.post('/login', this.data)
          .then((response) => {
            if(response?.status === 200 && response.data?.two_factor) {
              this.$router.replace({name: 'TwoFactorChallenge'})
              return;
            }

            this.$store.dispatch('attempt_user')
              .then((response) => {
                console.log(response);
                if(response?.status === 200) {
                  if(!this.$route.redirectedFrom) {
                    this.$router.push('/')
                  } else {
                    this.$router.push(this.$route.redirectedFrom.fullPath)
                  }

                }
              })
          })
          .catch((error) => {
            console.log(error);
            this.errors = error.response.data
          })
      });
    }
  }
}
</script>
