import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/gamification',
    method: 'get',
    params: query
  })
}

export function fetchRecord(id) {
  return request({
    url: `/gamification/${id}`,
    method: 'get'
  })
}

export function create(data) {
  return request({
    url: '/gamification',
    method: 'post',
    data
  })
}

export function update(id, data) {
  return request({
    url: `/gamification/${id}`,
    method: 'put',
    data
  })
}
