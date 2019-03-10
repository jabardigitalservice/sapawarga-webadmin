import $store from '@/store'

class AuthService {
  makeLogin (data) {
    return new Promise((resolve) => {
      setTimeout(() => {
        console.log(data) /* eslint-disable-line */

        $store.commit('auth/SET_CURRENT_USER', {
          id: 1,
          name: 'User'
        })

        resolve({
          data: {}
        })
      }, 2000)
    })
  }

  makeLogout () {
    return new Promise((resolve) => {
      setTimeout(() => {
        $store.commit('auth/SET_CURRENT_USER', {
          id: null,
          name: null
        })

        resolve()
      }, 2000)
    })
  }

  makeRegister (data) {
    return new Promise((resolve) => {
      setTimeout(() => {
        console.log(data) /* eslint-disable-line */

        $store.commit('auth/SET_CURRENT_USER', {
          id: 1,
          name: 'User'
        })

        resolve({
          data: {}
        })
      }, 2000)
    })
  }
}

export default new AuthService()
