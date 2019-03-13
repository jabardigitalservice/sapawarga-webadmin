import axios from 'axios'

import $store from '@/store'
import { API_URL, ACCESS_TOKEN_PREFIX } from '@/config'
import { ResponseWrapper, ErrorWrapper } from './util'

import UsersService from './users.service'

class AuthService {
  makeLogin (data) {
    return new Promise((resolve, reject) => {
      // 1. Get Access Token
      axios.post(`${API_URL}/staff/login`, {
        LoginForm: {
          username: data.username,
          password: data.password
        }
      }).then(response => {
        _setAuthData(response)

        // 2. Get Current User Profile
        resolve(this.getCurrent())
      }).catch(error => reject(new ErrorWrapper(error)))
    })
  }

  loginWithExistingAccessToken () {
    return new Promise((resolve, reject) => {
      const token = this.getAccessToken()

      if (token) {
        this.getCurrent().then(response => {
          resolve(new ResponseWrapper(response, response.data))
        }).catch(error => reject(new ErrorWrapper(error)))
      }
    })
  }

  getCurrent () {
    return new Promise((resolve, reject) => {
      UsersService.getCurrent().then(response => {
        $store.commit('auth/SET_CURRENT_USER', {
          id: response.data.id,
          username: response.data.username,
          name: null,
          email: response.data.email
        })

        resolve(new ResponseWrapper(response, response.data))
      }).catch(error => reject(new ErrorWrapper(error)))
    })
  }

  makeLogout () {
    return new Promise((resolve) => {
      setTimeout(() => {
        _resetAuthData()

        resolve()
      }, 2000)
    })
  }

  makeRegister (data) {
    //
  }

  getAccessToken () {
    return localStorage.getItem(`${ACCESS_TOKEN_PREFIX}_accessToken`)
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
  $store.commit('auth/SET_CURRENT_USER', {
    id: null,
    username: null,
    email: null
  })
  // $store.commit('auth/SET_ATOKEN_EXP_DATE', null)
  // reset tokens in localStorage
  // localStorage.setItem('refreshToken', '')
  localStorage.setItem(`${ACCESS_TOKEN_PREFIX}_accessToken`, '')
}

function _setAuthData (response) {
  // localStorage.setItem('refreshToken', response.data.refreshToken)
  localStorage.setItem(`${ACCESS_TOKEN_PREFIX}_accessToken`, response.data.data.access_token)
  // $store.commit('auth/SET_ATOKEN_EXP_DATE', response.data.expires_in)
}

export default new AuthService()
