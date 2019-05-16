import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/broadcasts',
    method: 'get',
    params: query
  })
}

export function fetchRecord(id) {
  return request({
    url: `/broadcasts/${id}`,
    method: 'get'
  })
}

export function create(data) {
  return request({
    url: '/broadcasts',
    method: 'post',
    data
  })
}

export function update(id, data) {
  return request({
    url: `/broadcasts/${id}`,
    method: 'put',
    data
  })
}
