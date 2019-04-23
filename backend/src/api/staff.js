import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/staff',
    method: 'get',
    params: query
  })
}

export function activate(id) {
  return request({
    url: `/staff/${id}`,
    method: 'put',
    data: {
      status: 10
    }
  })
}

export function deactivate(id) {
  return request({
    url: `/staff/${id}`,
    method: 'put',
    data: {
      status: 0
    }
  })
}
