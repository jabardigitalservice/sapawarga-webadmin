import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/banner',
    method: 'get',
    params: query
  })
}

export function fetchRecord(id) {
  return request({
    url: `/banner/${id}`,
    method: 'get'
  })
}

export function create(data) {
  return request({
    url: '/banner',
    method: 'post',
    data
  })
}

export function update(id, data) {
  return request({
    url: `/banner/${id}`,
    method: 'put',
    data
  })
}
