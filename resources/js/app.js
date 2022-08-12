import { createApp } from 'vue'
import store from '@/js/stores';
import router from '@/js/router';
import App from '@/js/layouts/App';
import Card from "./components/Card";
import Loading from "./components/Loading";
import DefaultTemplate from "./layouts/DefaultTemplate";
import Modal from "./components/Modal";
import ConfirmButton from "./components/ConfirmButton";
import HeaderImage from "./components/HeaderImage";
import Widget from "./components/Widget";
import Pagination from 'v-pagination-3';


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
        .component("Card", Card)
        .component("Modal",Modal)
        .component("ConfirmButton",ConfirmButton)
        .component("HeaderImage",HeaderImage)
        .component("Loading", Loading)
        .component("pagination", Pagination)
        .component("Widget",Widget);


    app.mount('#app');
  });
