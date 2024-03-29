<template>
  <div>

    <teleport to="head">
      <title>Whichcote Arms | Account</title>
      <meta name="description" content="Manage Your Account" />
    </teleport>


    <h3 v-if="active">You have enabled two factor authentication.</h3>
    <h3 v-else>You have not enabled two factor authentication.</h3>

    <p class="mt-3 text-sm text-gray-600">
      When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator application.
    </p>

    <div v-if="qrCode && !active" class="max-w-lg flex py-4">
      <div>
        <div v-if="qrCode" v-html="qrCode.svg" class="pr-4"></div>
        <div v-if="setupKey" class="text-gray-600 text-sm">Setup Key: <span class="text-base">{{ setupKey }}</span></div>
      </div>
      <form @submit.prevent="twoFactorChallenge">
        <p class="text-sm text-gray-600 pb-4">
          To activate Two-Factor-Authentication scan the QR-Code and enter your first TOTP-Code here.
        </p>
        <div>
          <label class="block font-medium text-sm text-gray-500" for="code">Two Factor Code</label>
          <input v-model="code" class="p-2 rounded-md shadow-sm bg-white border border-gray-300 text-gray-400 block mt-1 w-full" id="code" type="text" name="code" required="required">
        </div>
        <div v-if="errors" class="text-red-500 py-2 font-semibold">
          <span>{{ errors.message }}</span>
        </div>
        <div class="flex items-center justify-end mt-4">
          <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white  tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-3">
            Activate 2FA
          </button>
        </div>
      </form>
    </div>

    <div v-if="active && recoveryCodes" class="grid gap-1 max-w-xl mt-4 p-4 font-mono text-sm bg-gray-100 rounded-lg">
      <div v-for="backupCode in recoveryCodes" :key="backupCode">{{ backupCode }}</div>
    </div>

    <div class="space-x-2 mt-3">
      <button v-if="!active && !qrCode" @click="activate" class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white  tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Activate</button>
      <button v-if="active && !recoveryCodes" @click="loadRecoveryCodes" class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white  tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Show Recovery-Codes</button>
      <button v-if="active && recoveryCodes" @click="resetRecoveryCodes" class="inline-flex items-center px-4 py-2 bg-transparent border border-gray-600 rounded-md font-semibold text-xs text-gray-500  tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Reset Recovery-Codes</button>
      <button v-if="active" @click="deactivate" class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white  tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Deactivate</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      recoveryCodes: null,
      qrCode: null,
      setupKey: null,
      errors: null,
      code: null,
    }
  },
  computed: {
    user() {
      return this.$store.getters.user
    },
    active() {
      return this.user?.two_factor
    }
  },
  methods: {
    activate() {
      axios.post('/user/two-factor-authentication')
        .then((response) => {
          this.$store.dispatch('attempt_user')
            .then(() => {
              this.loadQrCode()
              this.loadSetupKey()
            })
        })
        .catch((error) => {
          this.errors = error.response.data
        })
    },
    twoFactorChallenge() {
       axios.post('/user/confirmed-two-factor-authentication', { code: this.code })
        .then((response) => {
          this.$store.dispatch('attempt_user')
        })
        .catch((error) => {
          this.errors = error.response.data
        })
    },
    loadQrCode() {
      axios.get('/user/two-factor-qr-code')
        .then((response) => {
          this.qrCode = response.data
        })
        .catch((error) => {
          this.errors = error.response.data
        })
    },
    loadSetupKey() {
      axios.get('/user/two-factor-secret-key')
        .then((response) => {
          this.setupKey = response.data.secretKey
        })
        .catch((error) => {
          this.errors = error.response.data
        })
    },
    loadRecoveryCodes() {
      axios.get('/user/two-factor-recovery-codes')
        .then((response) => {
          this.recoveryCodes = response.data
        })
        .catch((error) => {
          this.errors = error.response.data
        })
    },
    resetRecoveryCodes() {
      axios.post('/user/two-factor-recovery-codes')
        .then((response) => {
          if(response.status === 200) {
            this.loadRecoveryCodes()
          }
        })
        .catch((error) => {
          this.errors = error.response.data
        })
    },
    deactivate() {
      const confirmed = confirm('Are you sure you want to deactivate Two Factor Authentication?')
      if(!confirmed) return

      axios.delete('/user/two-factor-authentication')
        .then((response) => {
          this.$store.dispatch('attempt_user')
        })
        .catch((error) => {
          this.errors = error.response.data
        })
    },
  }
}
</script>
