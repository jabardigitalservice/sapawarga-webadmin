import BaseService from './base.service'

class ArticlesService extends BaseService {
    get entity () {
        return 'guitar'
    }
}

export default new ArticlesService()
