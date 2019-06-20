import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/notifications',
    method: 'get',
    params: query
  })
}

export function fetchRecord(id) {
  return request({
    url: `/notifications/${id}`,
    method: 'get'
  })
}

export function create(data) {
  return request({
    url: '/notifications',
    method: 'post',
    data
  })
}

export function update(id, data) {
  return request({
    url: `/notifications/${id}`,
    method: 'put',
    data
  })
}
