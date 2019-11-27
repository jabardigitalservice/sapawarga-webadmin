import request from '@/utils/request'

export function fetchListUser(query) {
  return request({
    url: '/staff',
    method: 'get',
    params: query
  })
}
