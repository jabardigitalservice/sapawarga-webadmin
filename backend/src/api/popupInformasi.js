import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/popups',
    method: 'get',
    params: query
  })
}

export function fetchRecord(id) {
  return request({
    url: `/popups/${id}`,
    method: 'get'
  })
}

export function create(data) {
  return request({
    url: '/popups',
    method: 'post',
    data
  })
}

export function update(id, data) {
  return request({
    url: `/popups/${id}`,
    method: 'put',
    data
  })
}

export function deleteData(id) {
  return request({
    url: `/popups/${id}`,
    method: 'delete'
  })
}
