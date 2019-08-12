import { login, getInfo } from '@/api/user'
import { getToken, setToken, removeToken } from '@/utils/auth'
import router, { resetRouter } from '@/router'
import { Message } from 'element-ui'

const state = {
  token: getToken(),
  name: '',
  avatar: '',
  introduction: '',
  roles: [],
  roles_active: {
    id: null,
    label: null
  },
  kel_id: null,
  kec_id: null,
  kabkota_id: null,
  kabkota: null,
  kecamatan: null,
  kelurahan: null,
  dummy_image: require('@/assets/user.png')
}

const mutations = {
  SET_TOKEN: (state, token) => {
    state.token = token
  },
  SET_INTRODUCTION: (state, introduction) => {
    state.introduction = introduction
  },
  SET_NAME: (state, name) => {
    state.name = name
  },
  SET_AVATAR: (state, avatar) => {
    state.avatar = avatar
  },
  SET_ROLES: (state, roles) => {
    state.roles = roles
  },
  SET_ROLES_ACTIVE: (state, data) => {
    state.roles_active = data
  },
  SET_AREA: (state, data) => {
    state.kel_id = parseInt(data.kel_id) || null // @TODO perbaiki dari API
    state.kec_id = parseInt(data.kec_id) || null
    state.kabkota_id = parseInt(data.kabkota_id) || null
    state.kabkota = data.kabkota
    state.kecamatan = data.kecamatan
    state.kelurahan = data.kelurahan
  }
}

const actions = {
  // user login
  login({ commit }, userInfo) {
    const { username, password } = userInfo

    return new Promise((resolve, reject) => {
      login({ LoginForm: { username: username.trim(), password: password }})
        .then(response => {
          const { data } = response
          commit('SET_TOKEN', data.access_token)
          setToken(data.access_token)
          resolve()
        })
        .catch(error => {
          const errData = error.response.data.data

          // PS: seharusnya ketika salah username & password. di error.response.data.data.status memiliki status khusus. By Ganjar Setia
          if (error.response.status === 422) {
            let errMessage = errData.password[0]

            // jika user inactive atau mengandung status apapun
            if (errData.status) errMessage = errData.status[0]

            Message({
              message: errMessage,
              type: 'error',
              duration: 5 * 1000
            })
          }
          reject()
        })
    })
  },

  // get user info
  getInfo({ commit, state }) {
    return new Promise((resolve, reject) => {
      getInfo(state.token)
        .then(response => {
          let { data } = response
          const dummy_image = state.dummy_image

          if (!data) {
            reject('Verification failed, please Login again.')
          }

          const { name, role_label, role_id, photo_url } = data

          const roles = [role_id] // @TODO sebaiknya bisa multiple dan switch roles

          // roles must be a non-empty array
          if (!roles || roles.length <= 0) {
            reject('getInfo: roles must be a non-null array!')
          }

          commit('SET_ROLES', roles)

          commit('SET_ROLES_ACTIVE', {
            id: role_id,
            label: role_label
          })

          commit('SET_NAME', name)
          if (photo_url == null) {
            commit('SET_AVATAR', dummy_image)
          } else {
            commit('SET_AVATAR', photo_url)
          }

          const { kel_id, kec_id, kabkota_id, kabkota, kecamatan, kelurahan } = data
          const kabkotaName = !kabkota ? null : kabkota.name
          const kecamatanName = !kecamatan ? null : kecamatan.name
          const kelurahanName = !kelurahan ? null : kelurahan.name

          commit('SET_AREA', {
            kel_id: kel_id,
            kec_id: kec_id,
            kabkota_id: kabkota_id,
            kabkota: kabkotaName,
            kecamatan: kecamatanName,
            kelurahan: kelurahanName
          })

          data = roles
          resolve(data)
        })
        .catch(error => {
          reject(error)
        })
    })
  },

  // user logout
  logout({ commit }) {
    return new Promise((resolve, reject) => {
      commit('SET_TOKEN', '')
      commit('SET_ROLES', [])
      removeToken()
      resetRouter()
      resolve()
    })
  },

  // remove token
  resetToken({ commit }) {
    return new Promise(resolve => {
      commit('SET_TOKEN', '')
      commit('SET_ROLES', [])
      removeToken()
      resolve()
    })
  },

  // Dynamically modify permissions
  changeRoles({ commit, dispatch }, role) {
    return new Promise(async resolve => {
      const token = role + '-token'

      commit('SET_TOKEN', token)
      setToken(token)

      const { roles } = await dispatch('getInfo')

      resetRouter()

      // generate accessible routes map based on roles
      const accessRoutes = await dispatch('permission/generateRoutes', roles, {
        root: true
      })

      // dynamically add accessible routes
      router.addRoutes(accessRoutes)

      resolve()
    })
  }
}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}
