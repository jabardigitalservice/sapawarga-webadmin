import request from '@/utils/request'

export function fetchListUser() {
  return request({
    url: '/staff',
    method: 'get'
  })
}
