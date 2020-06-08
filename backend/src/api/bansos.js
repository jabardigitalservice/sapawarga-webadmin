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

export function exportBansos(query) {
  return request({
    url: `/beneficiaries-bnba/download`,
    method: 'get',
    params: query
  })
}
