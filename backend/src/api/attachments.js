import request from '@/utils/request'

export function upload(data) {
  return request({
    url: '/attachments',
    method: 'post',
    data
  })
}
