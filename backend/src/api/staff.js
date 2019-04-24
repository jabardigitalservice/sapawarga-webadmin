import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/staff',
    method: 'get',
    params: query
  })
}

export function totalUser() {
  return request({
    url: '/staff/count',
    method: 'get'
  })
}
