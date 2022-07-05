import { createApp } from 'vue'
import store from '@/js/stores';
import router from '@/js/router';
import App from '@/js/layouts/App';
import Card from "./components/Card";
import Loading from "./components/Loading";
import DefaultTemplate from "./layouts/DefaultTemplate";
import AdminTemplate from "./layouts/AdminTemplate";
import Modal from "./components/Modal";
import ConfirmButton from "./components/ConfirmButton";


window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Content-Type'] = 'application/json';
window.axios.defaults.headers.common['Accept'] = 'application/json';
window.axios.defaults.withCredentials = true;

store.dispatch('attempt_user')
  .then(() => {
    const app = createApp(App)
        .use(store)
        .use(router)
        .component("DefaultTemplate",DefaultTemplate)
        .component("AdminTemplate",AdminTemplate)
        .component("Card", Card)
        .component("Modal",Modal)
        .component("ConfirmButton",ConfirmButton)
        .component("Loading", Loading);

    app.mount('#app');
  });
