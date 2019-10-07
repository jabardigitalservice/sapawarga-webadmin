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

export function deleteData(id) {
  return request({
    url: `/banners/${id}`,
    method: 'delete'
  })
}

export function deactivate(id) {
  return request({
    url: `/banners/${id}`,
    method: 'put',
    data: {
      status: 0
    }
  })
}

export function activate(id) {
  return request({
    url: `/banners/${id}`,
    method: 'put',
    data: {
      status: 10
    }
  })
}
