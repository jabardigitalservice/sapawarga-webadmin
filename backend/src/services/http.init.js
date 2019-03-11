/**
 * HTTP request layer
 * if auth is required return patched axios instance(with access token in headers)
 * else return clear axios instance
 */

import axios from 'axios'

import authService from '@/services/auth.service'

export default class Http {
  constructor (status) {
    this.isAuth = status && status.auth ? status.auth : false
    this.instance = axios.create({
      baseURL: process.env.VUE_APP_API_URL
    })

    return this.init()
  }

  init () {
    if (this.isAuth) {
      this.instance.interceptors.request.use(request => {
        request.headers['Authorization'] = `Bearer ${authService.getAccessToken()}`
        // if access token expired and refreshToken is exist >> go to API and get new access token
        if (authService.isAccessTokenExpired() && authService.getRefreshToken()) {
          return authService.refreshTokens()
            .then(response => {
              request.headers['Authorization'] = `Bearer ${response.data.accessToken}`
              return request
            }).catch(error => Promise.reject(error))
        } else {
          return request
        }
      }, error => {
        return Promise.reject(error)
      })

      return this.instance
    }
    return this.instance
  }
}
