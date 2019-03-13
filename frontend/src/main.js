import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import setGlobalHelpers from './global.helpers'

import BootstrapVue from 'bootstrap-vue'
import VueMoment from 'vue-moment'

import VuePromiseBtn from 'vue-promise-btn'
import 'vue-promise-btn/dist/vue-promise-btn.css'

setGlobalHelpers()
Vue.config.productionTip = false

Vue.use(BootstrapVue)
Vue.use(VueMoment)
Vue.use(VuePromiseBtn)

new Vue({
  el: '#app',
  router,
  store,
  render: h => h(App)
})
