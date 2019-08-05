import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/videos',
    method: 'get',
    params: query
  })
}

export function fetchStatistic() {
  return request({
    url: '/videos/statistics',
    method: 'get'
  })
}

export function fetchRecord(id) {
  return request({
    url: `/videos/${id}`,
    method: 'get'
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
