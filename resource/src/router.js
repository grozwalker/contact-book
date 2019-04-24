import Vue from 'vue'
import VueRouter from 'vue-router'

import HomePage from './components/MainPage'
import ContactPage from './components/Contact'

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomePage
  },
  {
    path: '/contact/:id(\\d+)',
    name: 'contact',
    component: ContactPage
  },
];

const router = new VueRouter({
  routes
});

export default router;
