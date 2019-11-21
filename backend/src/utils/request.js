import axios from 'axios'
import { Message } from 'element-ui'
import store from '@/store'
import router from '@/router'
import { getToken } from '@/utils/auth'
import { ResponseRequest } from '@/utils/constantVariabel'
import i18n from '@/lang'
// create an axios instance
const service = axios.create({
  baseURL: process.env.VUE_APP_BASE_API, // api 的 base_url
  withCredentials: false, // 跨域请求时发送 cookies
  timeout: 10000 // request timeout
})

// request interceptor
service.interceptors.request.use(
  config => {
    // Do something before request is sent
    if (store.getters.token) {
      // 让每个请求携带token-- ['X-Token']为自定义key 请根据实际情况自行修改
      config.headers['Authorization'] = 'Bearer ' + getToken()
    }
    return config
  },
  error => {
    // Do something with request error
    Promise.reject(error)
  }
)

// response interceptor
service.interceptors.response.use(
  /**
   * If you want to get information such as headers or status
   * Please return  response => response
   */
  response => {
    const res = response.data

    return res
  },
  error => {
    if (error.code === ResponseRequest.TIMEOUT) {
      Message({
        message: i18n.t('errors.request-timeout'),
        type: 'error',
        duration: 5 * 1000
      })
    }

    if (error.message === ResponseRequest.NETWORKERROR) {
      Message({
        message: i18n.t('errors.request-timeout'),
        type: 'error',
        duration: 5 * 1000
      })
    }

    if (error.response && error.response.status === ResponseRequest.FORBIDDEN) {
      router.push('/403')
    }

    if (error.response && error.response.status === ResponseRequest.NOTFOUND) {
      router.push('/404')
    }

    if (error.response && error.response.status === ResponseRequest.SERVERERROR) {
      let message = i18n.t('errors.internal-server-error')
      if (error.response.data.data !== undefined) {
        message = error.response.data.data.message
      }
      Message({
        message: message,
        type: 'error',
        duration: 5 * 1000
      })
    }

    if (error.response && error.response.status !== ResponseRequest.UNPROCESSABLE) {
      Message({
        message: i18n.t('errors.internal-server-error'),
        type: 'error',
        duration: 5 * 1000
      })
    }

    return Promise.reject(error)
  }
)

export default service
