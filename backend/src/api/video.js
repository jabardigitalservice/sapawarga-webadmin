import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/videos',
    method: 'get',
    params: query,
    baseURL: 'http://35.247.135.93.xip.io:3000/api/v1/'
  })
}

export function fetchRecord(id) {
  return request({
    url: `/videos/${id}`,
    method: 'get',
    baseURL: 'http://35.247.135.93.xip.io:3000/api/v1/'
  })
}

export function create(data) {
  return request({
    url: '/videos',
    method: 'post',
    data
  })
}

export function update(id, data) {
  return request({
    url: `/videos/${id}`,
    method: 'put',
    data
  })
}

export function deleteData(id) {
  return request({
    url: `/videos/${id}`,
    method: 'delete'
  })
}

export function deactivate(id) {
  return request({
    url: `/videos/${id}`,
    method: 'put',
    data: {
      status: 0
    }
  })
}

export function activate(id) {
  return request({
    url: `/videos/${id}`,
    method: 'put',
    data: {
      status: 10
    }
  })
}
