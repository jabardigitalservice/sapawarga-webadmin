import BaseService from './base.service'

class UsersService extends BaseService {
    get entity () {
        return 'users'
    }

    getCurrent () {
        return new Promise((resolve, reject) => {
            return this.request({ auth: true }).get(`user/me`)
                .then(response => resolve(this.responseWrapper(response, response.data.data)))
                .catch(error => {
                    let message = error.response.data ? error.response.data.error : error.response.statusText
                    reject(this.errorWrapper(error, message))
                })
        })
    }
}

export default new UsersService()
