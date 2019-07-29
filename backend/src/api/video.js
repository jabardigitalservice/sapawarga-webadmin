import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/video',
    method: 'get',
    params: query
  })
}

export function fetchRecord(id) {
  return request({
    url: `/video/${id}`,
    method: 'get'
  })
}

export function create(data) {
  return request({
    url: '/video',
    method: 'post',
    data
  })
}

export function update(id, data) {
  return request({
    url: `/video/${id}`,
    method: 'put',
    data
  })
}
