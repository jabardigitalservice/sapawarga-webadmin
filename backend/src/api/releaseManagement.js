import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/releases',
    method: 'get',
    params: query
  })
}

export function create(data) {
  return request({
    url: '/releases',
    method: 'post',
    data
  })
}

export function fetchRecord(id) {
  return request({
    url: `/releases/${id}`,
    method: 'get'
  })
}

export function update(id, data) {
  return request({
    url: `/releases/${id}`,
    method: 'put',
    data
  })
}

export function deleteData(id) {
  return request({
    url: `/releases/${id}`,
    method: 'delete'
  })
}
