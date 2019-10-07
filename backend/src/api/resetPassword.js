import request from '@/utils/request'

export function checkToken(data) {
  return request({
    url: `/user/password-reset-token-verification`,
    method: 'post',
    data
  })
}

export function resetPassword(data) {
  return request({
    url: '/user/password-reset',
    method: 'post',
    data
  })
}
