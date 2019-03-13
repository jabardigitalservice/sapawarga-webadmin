import Vue from 'vue'
import Vuex from 'vuex'

import auth from './auth'

import articles from './articles'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    auth,
    articles
  }
})

export default store
