import Vue from 'vue'

import moment from 'moment'
moment.locale('id')

import VueMoment from 'vue-moment'
import VueTheMask from 'vue-the-mask'
import L from 'leaflet'

import Cookies from 'js-cookie'

import 'normalize.css/normalize.css' // A modern alternative to CSS resets

import Element from 'element-ui'
import './styles/element-variables.scss'

import '@/styles/index.scss' // global css
import '@/styles/main.scss' // costume css

import _ from 'lodash'
Object.defineProperty(Vue.prototype, '_', { value: _ })

import App from './App'
import store from './store'
import router from './router'

import i18n from './lang' // Internationalization
import './icons' // icon
import './permission' // permission control
import './utils/errorLog' // error log

import * as filters from './filters' // global filters

import { mockXHR } from '../mock' // simulation data

import * as Sentry from '@sentry/browser'
import * as Integrations from '@sentry/integrations'

if (process.env.VUE_APP_NODE_ENV === 'production') {
  Sentry.init({
    environment: process.env.VUE_APP_ERROR_ENVIRONMENT,
    dsn: process.env.VUE_APP_SENTRY_DSN,
    release: process.env.VUE_APP_VERSION,
    integrations: [new Integrations.Vue({ Vue, attachProps: true })]
  })
  Sentry.configureScope((scope) => {
    scope.setTag('User', '')
    scope.setUser({
      id: parseInt(store.getters.user_id)
    })
  })
}
// mock api in github pages site build
if (process.env.VUE_APP_NODE_ENV === 'production') { mockXHR() }

Vue.use(Element, {
  size: Cookies.get('size') || 'medium', // set element-ui default size
  i18n: (key, value) => i18n.t(key, value)
})

Vue.use(VueMoment, {
  moment
})

Vue.use(VueTheMask)
Vue.use(L)
// register global utility filters.
Object.keys(filters).forEach(key => {
  Vue.filter(key, filters[key])
})

Vue.config.productionTip = false

new Vue({
  el: '#app',
  router,
  store,
  i18n,
  render: h => h(App)
})
