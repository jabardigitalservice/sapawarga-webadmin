import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/gamifications',
    method: 'get',
    params: query
  })
}

export function fetchRecord(id) {
  return request({
    url: `/gamifications/${id}`,
    method: 'get'
  })
}

export function create(data) {
  return request({
    url: '/gamifications',
    method: 'post',
    data
  })
}

export function update(id, data) {
  return request({
    url: `/gamifications/${id}`,
    method: 'put',
    data
  })
}

export function deactivate(id) {
  return request({
    url: `/gamifications/${id}`,
    method: 'delete'
  })
}

export function fetchListParticipant(query) {
  return request({
    url: '/gamifications/participant',
    method: 'get',
    params: query
  })
}
