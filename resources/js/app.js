/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'

Vue.use(VueRouter)

Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('add-project', require('./components/AddProjectComponent.vue').default);

import Home from './components/HomeComponent.vue';
import Project from './components/ProjectComponent.vue';

const routes = [
  { path: '/home',
    component: Home
  },
  { path: '/missions',
    component: Project
  }
]

const router = new VueRouter({
  routes // short for `routes: routes`
})

const app = new Vue({
  el: '#app',
  router: router
})
