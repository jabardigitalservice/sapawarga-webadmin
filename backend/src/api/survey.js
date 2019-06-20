import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/survey',
    method: 'get',
    params: query
  })
}

export function fetchRecord(id) {
  return request({
    url: `/survey/${id}`,
    method: 'get'
  })
}

export function create(data) {
  return request({
    url: '/survey',
    method: 'post',
    data
  })
}

export function update(id, data) {
  return request({
    url: `/survey/${id}`,
    method: 'put',
    data
  })
}
