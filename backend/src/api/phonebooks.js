import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/phone-books',
    method: 'get',
    params: query
  })
}

export function fetchRecord(id) {
  return request({
    url: `/phone-books/${id}`,
    method: 'get'
  })
}

export function activate(id) {
  return request({
    url: `/phone-books/${id}`,
    method: 'put',
    data: {
      status: 10
    }
  })
}

export function deactivate(id) {
  return request({
    url: `/phone-books/${id}`,
    method: 'put',
    data: {
      status: 0
    }
  })
}

export function create(data) {
  return request({
    url: '/phone-books',
    method: 'post',
    data
  })
}

export function update(id, data) {
  return request({
    url: `/phone-books/${id}`,
    method: 'put',
    data
  })
}
