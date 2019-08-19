import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/dashboards/aspirasi-most-likes',
    method: 'get',
    params: query
  })
}

