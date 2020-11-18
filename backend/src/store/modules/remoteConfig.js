
const state = {
  banners: []
}

const mutations = {
  ADD_BANNERS: (state, banners) => {
    state.banners = banners
  }
}

const actions = {
  addBanners({ commit }, banners) {
    commit('ADD_BANNERS', banners)
  }
}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}
