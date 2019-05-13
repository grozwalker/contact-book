import Vue from 'vue'
import App from './App.vue'

import axios from 'axios'

import router from './router';
import styles from './assets/styles.scss';

Vue.config.productionTip = false;

Vue.use({
  install (Vue) {
    Vue.prototype.$api = axios.create({
      baseURL: 'http://localhost:8089/'
    })
  }
});

new Vue({
  router,
  render: h => h(App),
}).$mount('#app');
