import request from '@/utils/request'

export function fetchList(query) {
  return request({
    // url: '/news-important',
    baseURL: 'http://52.74.74.33:3000/api/v1/news-important',
    method: 'get',
    params: query
  })
}

export function fetchRecord(id) {
  return request({
    url: `/news-important/${id}`,
    method: 'get'
  })
}

export function create(data) {
  return request({
    url: '/news-important',
    method: 'post',
    data
  })
}

export function update(id, data) {
  return request({
    url: `/news-important/${id}`,
    method: 'put',
    data
  })
}

export function deleteData(id) {
  return request({
    url: `/news-important/${id}`,
    method: 'delete'
  })
}

export function deactivate(id) {
  return request({
    url: `/news-important/${id}`,
    method: 'put',
    data: {
      status: 0
    }
  })
}

export function activate(id) {
  return request({
    url: `/news-important/${id}`,
    method: 'put',
    data: {
      status: 10
    }
  })
}
