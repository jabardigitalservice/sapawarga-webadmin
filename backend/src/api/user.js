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
    url: '/user/me',
    method: 'get'
    // params: { token }
  })
}

export function getUserInfo(id) {
  return request({
    url: `/staff/${id}`,
    method: 'get'
    // params: { token }
  })
}

// export function logout() {
//   return request({
//     url: '/user/logout',
//     method: 'post'
//   });
// }
