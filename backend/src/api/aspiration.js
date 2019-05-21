import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/aspirasi',
    method: 'get',
    params: query
  })
}

export function fetchRecord(id) {
  return request({
    url: `/aspirasi/${id}`,
    method: 'get'
  })
}

export function create(data) {
  return request({
    url: '/aspirasi',
    method: 'post',
    data
  })
}

export function update(id, data) {
  return request({
    url: `/aspirasi/${id}`,
    method: 'put',
    data
  })
}
