import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/aspirasi',
    method: 'get',
    params: query
  })
}

export function fetchRecord(id) {
  return request({
    url: `/aspirasi/${id}`,
    method: 'get'
  })
}

export function create(data) {
  return request({
    url: '/aspirasi',
    method: 'post',
    data
  })
}

export function update(id, data) {
  return request({
    url: `/aspirasi/${id}`,
    method: 'put',
    data
  })
}

export function approval(id, data) {
  return request({
    url: `/aspirasi/approval/${id}`,
    method: 'post',
    data
  })
}

export function unpublish(id) {
  return request({
    url: `/aspirasi/${id}`,
    method: 'put',
    data: {
      status: 7
    }
  })
}

export function publish(id, approval_note) {
  return request({
    url: `/aspirasi/${id}`,
    method: 'put',
    data: {
      status: 10,
      approval_note
    }
  })
}
