import request from '@/utils/request';

export function login(data) {
  return request({
    url: 'staff/login',
    method: 'post',
    data
  });
}

export function getInfo(token) {
  return request({
    url: '/user/me',
    method: 'get'
    // params: { token }
  });
}

export function addUser(data) {
  return request({
    url: 'staff',
    method: 'post',
    data
  });
}

export function getRegion() {
  return request({
    url: 'areas',
    method: 'get',
    params: {
      parent_id: 1,
      depth: 2,
      all: true
    }
  });
}

export function getKecamatan(id) {
  return request({
    url: 'areas',
    method: 'get',
    params: {
      parent_id: id,
      depth: 3,
      all: true
    }
  });
}

export function getKelurahan(id) {
  return request({
    url: 'areas',
    method: 'get',
    params: {
      parent_id: id,
      depth: 4,
      all: true
    }
  });
}

// export function logout() {
//   return request({
//     url: '/user/logout',
//     method: 'post'
//   });
// }
