import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import App from '~/components/App'
import axios from 'axios'
import BootstrapVue from 'bootstrap-vue'

import '~/plugins'
import '~/components'

Vue.config.productionTip = false

Vue.prototype.$axios = axios;

Vue.use(BootstrapVue);

/* eslint-disable no-new */
new Vue({
  store,
  router,
  ...App
})
