import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/staff',
    method: 'get',
    params: query
  })
}