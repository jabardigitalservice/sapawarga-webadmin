import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/dashboards/aspirasi-most-likes',
    method: 'get',
    params: query
  })
}

export function fetchApproval(query) {
  return request({
    url: 'dashboards/aspirasi-counts',
    method: 'get',
    params: query
  })
}

