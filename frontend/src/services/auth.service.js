import axios from 'axios'

import $store from '@/store'
import { API_URL } from '@/config'
import { ResponseWrapper, ErrorWrapper } from './util'

import UsersService from './users.service'

class AuthService {
  makeLogin (data) {
    return new Promise((resolve, reject) => {
      // 1. Get Access Token
      axios.post(`${API_URL}/user/login`, {
        LoginForm: {
          username: data.username,
          password: data.password
        }
      }).then(response => {
        _setAuthData(response)

        const newResponse = new ResponseWrapper(response, response.data)
        const userId = newResponse.data.data.id

        // Get Current User Profile
        UsersService.getCurrent().then(response => {
          $store.commit('auth/SET_CURRENT_USER', {
            id: userId,
            name: null,
            email: response.data.email
          })

          resolve(new ResponseWrapper(response, response.data))
        }).catch(error => reject(new ErrorWrapper(error)))
      }).catch(error => reject(new ErrorWrapper(error)))
    })
  }

  makeLogout () {
    return new Promise((resolve) => {
      setTimeout(() => {
        _resetAuthData()

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

  getAccessToken () {
    return localStorage.getItem('accessToken')
  }

  getRefreshToken () {
    return localStorage.getItem('refreshToken')
  }

  isAccessTokenExpired () {
    return false
  }
}

/**
 ******************************
 * @methods
 ******************************
 */

function _resetAuthData () {
  // reset userData in store
  $store.commit('user/SET_CURRENT_USER', {})
  // $store.commit('auth/SET_ATOKEN_EXP_DATE', null)
  // reset tokens in localStorage
  // localStorage.setItem('refreshToken', '')
  localStorage.setItem('accessToken', '')
}

function _setAuthData (response) {
  // localStorage.setItem('refreshToken', response.data.refreshToken)
  localStorage.setItem('accessToken', response.data.data.access_token)
  // $store.commit('auth/SET_ATOKEN_EXP_DATE', response.data.expires_in)
}

export default new AuthService()
