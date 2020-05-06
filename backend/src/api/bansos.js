import request from '@/utils/request'

export function uploadBansos(data) {
  return request({
    url: '/bansos/upload',
    method: 'post',
    data
  })
}

export function uploadBansosList(query) {
  return request({
    url: '/bansos/upload',
    method: 'get',
    params: query
  })
}
