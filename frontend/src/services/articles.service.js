import BaseService from './base.service'

class ArticlesService extends BaseService {
    get entity () {
        return 'guitars'
    }
}

export default new ArticlesService()
