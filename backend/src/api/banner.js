import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/banners',
    method: 'get',
    params: query
  })
}

export function fetchRecord(id) {
  return request({
    url: `/banners/${id}`,
    method: 'get'
  })
}

export function create(data) {
  return request({
    url: '/banners',
    method: 'post',
    data
  })
}

export function update(id, data) {
  return request({
    url: `/banners/${id}`,
    method: 'put',
    data
  })
}
