import request from '@/utils/request'

export function create(data) {
  return request({
    url: '/broadcasts',
    method: 'post',
    data
  })
}
