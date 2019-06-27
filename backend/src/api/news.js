import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/news',
    method: 'get',
    params: query
  })
}

export function fetchRecord(id) {
  return request({
    url: `/news/${id}`,
    method: 'get'
  })
}

export function create(data) {
  return request({
    url: 'http://35.247.135.93:3000/api/v1/news',
    method: 'post',
    data
  })
}

export function update(id, data) {
  return request({
    url: `/news/${id}`,
    method: 'put',
    data
  })
}
