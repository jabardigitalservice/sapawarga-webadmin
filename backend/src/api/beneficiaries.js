import request from '@/utils/request'

export function fetchSummary(query) {
  return request({
    url: '/pub/beneficiaries/summary',
    method: 'get',
    params: query
  })
}

export function fetchList(query) {
  return request({
    url: '/beneficiaries',
    method: 'get',
    params: query
  })
}

export function fetchListJob(query) {
  return request({
    url: '/dinsos-job-types',
    method: 'get',
    params: query
  })
}

export function fetchNik(id) {
  return request({
    url: `/beneficiaries/nik/${id}`,
    method: 'get'
  })
}

export function checkNik(id) {
  return request({
    url: `/beneficiaries/check-exist-nik/${id}`,
    method: 'get'
  })
}

export function fetchRecord(id) {
  return request({
    url: `/beneficiaries/${id}`,
    method: 'get'
  })
}

export function create(data) {
  return request({
    url: '/beneficiaries',
    method: 'post',
    data
  })
}

export function update(id, data) {
  return request({
    url: `/beneficiaries/${id}`,
    method: 'put',
    data
  })
}
