import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: 'http://localhost:3000/v1/news-hoax',
    method: 'get',
    params: query
  })
}