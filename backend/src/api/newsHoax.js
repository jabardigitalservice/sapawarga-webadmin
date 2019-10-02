import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/news-hoax',
    method: 'get',
    params: query
  })
}

export function fetchRecord(id) {
  return request({
    url: `/news-hoax/${id}`,
    method: 'get'
  })
}
export function create(data) {
  return request({
    url: '/news-hoax',
    method: 'post',
    data
  })
}

export function update(id, data) {
  return request({
    url: `/news-hoax/${id}`,
    method: 'put',
    data
  })
}
export function deleteData(id) {
  return request({
    url: `/news-hoax/${id}`,
    method: 'delete'
  })
}

export function deactivate(id) {
  return request({
    url: `/news-hoax/${id}`,
    method: 'put',
    data: {
      status: 0
    }
  })
}

export function activate(id) {
  return request({
    url: `/news-hoax/${id}`,
    method: 'put',
    data: {
      status: 10
    }
  })
}

const exportFunctions = {
  fetchList,
  fetchRecord,
  create,
  update,
  deleteData,
  deactivate,
  activate
}

export default exportFunctions
