import Vue from 'vue'
import VueRouter from 'vue-router'

import HomePage from './components/MainPage'

Vue.use(VueRouter);

const Foo = { template: '<div>foo</div>' };
const Bar = { template: '<div>bar</div>' };

const routes = [
  { path: '/', component: HomePage },
  { path: '/foo', component: Foo },
  { path: '/bar', component: Bar }
];

const router = new VueRouter({
  routes // сокращённая запись для `routes: routes`
});

export default router;
