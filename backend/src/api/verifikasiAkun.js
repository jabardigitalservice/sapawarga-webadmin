import request from '@/utils/request'

export function verifikasiAkun(data) {
  return request({
    url: '/user/confirm',
    method: 'post',
    data
  })
}
