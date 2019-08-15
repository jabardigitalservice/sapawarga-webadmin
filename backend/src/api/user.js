import request from '@/utils/request'

export function login(data) {
  return request({
    url: 'staff/login',
    method: 'post',
    data
  })
}

export function getInfo(token) {
  return request({
    url: '/staff/me',
    method: 'get'
    // params: { token }
  })
}

export function fetchProfile() {
  return request({
    url: 'staff/me',
    method: 'get'
  })
}

export function update(data) {
  return request({
    url: 'staff/me',
    method: 'post',
    data
  })
}
