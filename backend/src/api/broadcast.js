import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/broadcasts',
    method: 'get',
    params: query
  })
}

export function create(data) {
  return request({
    url: '/broadcasts',
    method: 'post',
    data
  })
}
