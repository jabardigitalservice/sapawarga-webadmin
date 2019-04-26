import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/staff',
    method: 'get',
    params: query
  })
}

export function totalUser() {
  return request({
    url: '/staff/count',
    method: 'get'
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

export function requestArea() {
  return request({
    url: 'areas',
    method: 'get',
    params: {
      parent_id: 1,
      depth: 2,
      all: true
    }
  })
}

export function requestKecamatan(id) {
  return request({
    url: 'areas',
    method: 'get',
    params: {
      parent_id: id,
      depth: 3,
      all: true
    }
  })
}

export function requestKelurahan(id) {
  return request({
    url: 'areas',
    method: 'get',
    params: {
      parent_id: id,
      depth: 4,
      all: true
    }
  })
}

export function createUser(data) {
  return request({
    url: 'staff',
    method: 'post',
    data
  })
}

export function editUser(data) {
  return request({
    url: 'staff',
    method: 'put',
    data
  })
}

export function uploadImage(data) {
  return request({
    url: 'user/me/photo',
    method: 'post',
    data
  })
}

export function fetchUser(id) {
  return request({
    url: 'staff/' + id,
    method: 'get'
  })
}

