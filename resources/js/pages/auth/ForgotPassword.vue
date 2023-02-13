<template>
  <div id="ForgotPasswordPage" class="my-3">

    <teleport to="head">
      <title>Account | Forgotten Password</title>
      <meta name="description" content="Reset your password" />
    </teleport>

    <div class="w-full">
      <Card title="Forgotten Password">
        <form @submit.prevent="resetPassword">
          <div>
            <label class="block font-medium text-sm text-gray-500" for="email">
              Email
            </label>
            <input v-model="email" class="p-2 rounded-md shadow-sm bg-white border border-gray-300 text-gray-400 block mt-1 w-full" id="email" type="email" name="email" required="required" autofocus="autofocus">
          </div>
          <div v-if="errors" class="text-red-500 py-2 font-semibold">
            <span>{{ errors.message }}</span>
          </div>
          <div v-if="success" class="text-green-500 py-2 font-semibold">
            <span>{{ success.message }}</span>
          </div>
          <div class="flex items-center justify-end mt-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white  tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-3">
              Send Password-Reset E-Mail
            </button>
          </div>
        </form>
      </Card>

    </div>
  </div>
</template>

<script>


import Card from "../../components/Card";
export default {
  components: {Card},
  data: () => {
    return {
      email: null,
      errors: null,
      success: false
    }
  },

  methods: {
    resetPassword() {
      this.errors = null
      this.success=false;
      axios.post('/forgot-password', { email: this.email })
        .then((response) => {
          this.success=response.data;
        })
        .catch((error) => {
          this.errors = error.response.data
        })
    }
  }
}
</script>
