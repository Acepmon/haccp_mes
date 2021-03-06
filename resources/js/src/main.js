/*=========================================================================================
  File Name: main.js
  Description: main vue(js) file
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


import Vue from 'vue'
import App from './App.vue'

// Vuesax Component Framework
import Vuesax from 'vuesax'
Vue.use(Vuesax)


// axios
import axios from './axios.js'
axios.defaults.withCredentials = true
Vue.prototype.$http = axios

// Filters
import './filters/filters.js'


// Theme Configurations
import '../themeConfig.js'


// Globally Registered Components
import './globalComponents.js'


// Vue Router
import router from './router'


// Vuex Store
import store from './store/store'


// Vuejs - Vue wrapper for hammerjs
import { VueHammer } from 'vue2-hammer'
Vue.use(VueHammer)

// i18n
import i18n from './i18n/i18n'

// PrismJS
import 'prismjs'
import 'prismjs/themes/prism-tomorrow.css'

// Vue select css
// Note: In latest version you have to add it separately
// import 'vue-select/dist/vue-select.css';

import vSelect from 'vue-select'

Vue.component('v-select', vSelect)

import Pusher from "pusher-js"
import Echo from "laravel-echo"

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: '6da0f8a33a7fd0f225c5',
  cluster: 'ap3',
  forceTLS: false,
})

Vue.config.productionTip = false

new Vue({
  router,
  store,
  i18n,
  render: h => h(App)
}).$mount('#app')
