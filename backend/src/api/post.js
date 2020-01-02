import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/user-posts',
    method: 'get',
    params: query
  })
}

export function fetchRecord(id) {
  return request({
    url: `/user-posts/${id}`,
    method: 'get'
  })
}

export function deactivate(id) {
  return request({
    url: `/user-posts/${id}`,
    method: 'put',
    data: {
      status: 0
    }
  })
}

export function activate(id) {
  return request({
    url: `/user-posts/${id}`,
    method: 'put',
    data: {
      status: 10
    }
  })
}
