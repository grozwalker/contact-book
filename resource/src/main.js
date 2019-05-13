import Vue from 'vue'
import App from './App.vue'

import axios from 'axios'

import router from './router';
import './assets/styles.scss';

import { library } from '@fortawesome/fontawesome-svg-core';
import { faTrash } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

import Notifications from 'vue-notification';

library.add(faTrash);

Vue.component('font-awesome-icon', FontAwesomeIcon);

Vue.config.productionTip = false;

Vue.use({
  install (Vue) {
    Vue.prototype.$api = axios.create({
      baseURL: 'http://localhost:8089/'
    })
  }
});

Vue.use(Notifications);

new Vue({
  router,
  render: h => h(App),
}).$mount('#app');
