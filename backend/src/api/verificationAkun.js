import request from '@/utils/request'

export function verificationAkun(data) {
  return request({
    url: '/user/confirm',
    method: 'post',
    data
  })
}
