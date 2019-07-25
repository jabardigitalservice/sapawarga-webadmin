import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/categories',
    method: 'get',
    params: query
  })
}

const exportFunctions = {
  fetchList
}

export default exportFunctions
