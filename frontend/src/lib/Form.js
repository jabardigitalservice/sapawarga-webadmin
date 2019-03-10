import Http from '@/services//http.init'
import Errors from '@/lib/Errors'

export default class Form {
  constructor (data) {
    this.originalData = data

    for (let key in data) {
      this[key] = data[key]
    }

    this.errors = new Errors()

    return this
  }

  http (status = { auth: false }) {
    return new Http(status)
  }

  data () {
    let dataCopy = {}

    for (let key in this.originalData) {
      dataCopy[ key ] = this[ key ]
    }

    return dataCopy
  }

  post (url) {
    return this.submit('post', url)
  }

  put (url) {
    return this.submit('put', url)
  }

  patch (url) {
    return this.submit('patch', url)
  }

  delete (url) {
    return this.submit('delete', url)
  }

  callService (service, action) {
    this.errors.clear()

    return new Promise((resolve, reject) => {
      service[action](this.data())
        .then(({ data }) => {
          this.onSuccess(data)
          resolve(data)
        })
        .catch(e => {
          if (e.response && e.response.status === 422) {
            this.onError(e.response.data)
          }
          reject(e)
        })
    })
  }

  submit (requestType, url) {
    const method = requestType.toLowerCase()
    const data = this.data()

    this.errors.clear()

    return new Promise((resolve, reject) => {
      this.http().request({ method, url, data })
        .then(({ data }) => {
          this.onSuccess(data)
          resolve(data)
        })
        .catch(e => {
          if (e.response && e.response.status === 422) {
            this.onError(e.response.data)
          }
          reject(e)
        })
    })
  }

  onSuccess (data) { /* eslint-disable-line */
    this.reset()
  }

  onError (errors) {
    this.errors.record(errors)
  }

  reset () {
    for (let key in this.originalData) {
      this[key] = this.originalData[ key ]
    }

    this.errors.clear()
  }
}
