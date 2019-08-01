import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/news-channels',
    method: 'get',
    params: query
  })
}

export function create(data) {
  return request({
    url: '/news-channels',
    method: 'post',
    data
  })
}

export function deleteData(id) {
  return request({
    url: `/news-channels/${id}`,
    method: 'delete'
  })
}

const exportFunctions = {
  fetchList,
  create,
  deleteData
}

export default exportFunctions
