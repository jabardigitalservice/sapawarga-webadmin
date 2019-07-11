import request from '@/utils/request'

// url: 'http://35.247.135.93:3000/api/v1/news',
export function fetchList(query) {
  return request({
    url: '/news',
    method: 'get',
    params: query
  })
}

export function newsChannelList(query) {
  return request({
    url: '/news-channels',
    method: 'get',
    params: query
  })
}

function fetchRecord(id) {
  return request({
    url: `/news/${id}`,
    method: 'get'
  })
}

export function fetchStatistic() {
  return request({
    url: '/news/statistics',
    method: 'get'
  })
}

export function create(data) {
  return request({
    url: '/news',
    method: 'post',
    data
  })
}

export function update(id, data) {
  return request({
    url: `/news/${id}`,
    method: 'put',
    data
  })
}

export function approval(id, data) {
  return request({
    url: `/news/approval/${id}`,
    method: 'post',
    data
  })
}

export function deleteData(id) {
  return request({
    url: `/news/${id}`,
    method: 'delete'
  })
}

export function deactivate(id) {
  return request({
    url: `/news/${id}`,
    method: 'put',
    data: {
      status: 0
    }
  })
}

export function activate(id) {
  return request({
    url: `/news/${id}`,
    method: 'put',
    data: {
      status: 10
    }
  })
}

const exportFunctions = {
  fetchList,
  fetchRecord,
  deactivate,
  activate
}

export default exportFunctions
