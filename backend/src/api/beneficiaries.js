import request from '@/utils/request'

export function fetchSummary(query) {
  return request({
    url: '/pub/beneficiaries/summary',
    method: 'get',
    params: query
  })
}

export function fetchSummaryVerval(query) {
  return request({
    url: '/beneficiaries/approval-dashboard',
    method: 'get',
    params: query
  })
}

export function fetchDashboardSummary(query) {
  return request({
    url: '/beneficiaries/dashboard-summary',
    method: 'get',
    params: query
  })
}

export function fetchDashboardList(query) {
  return request({
    url: '/beneficiaries/dashboard-list',
    method: 'get',
    params: query
  })
}

export function fetchBnbaTahapSatuSummary(query) {
  return request({
    url: '/beneficiaries-bnba-tahap-satu/summary',
    method: 'get',
    params: query
  })
}

export function fetchBnbaTahapSatuList(query) {
  return request({
    url: '/beneficiaries-bnba-tahap-satu',
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

export function fetchListVerval(query) {
  return request({
    url: '/beneficiaries/approval',
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

export function fetchRecordBnba(id) {
  return request({
    url: `/beneficiaries-bnba-tahap-satu/${id}`,
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

export function validateStaffKel(id) {
  return request({
    url: `/beneficiaries/approval/${id}`,
    method: 'post',
    data: {
      action: 'APPROVE'
    }
  })
}

export function validateStaffKelBulk(id) {
  return request({
    url: `/beneficiaries/bulk-approval`,
    method: 'post',
    data: {
      'action': 'APPROVE',
      'ids': id
    }
  })
}

export function exportExcel(query) {
  return request({
    url: `/beneficiaries-bnba/download`,
    method: 'get',
    params: query,
    responseType: 'blob'
  })
}

export function fetchVervalUploadList(query) {
  return request({
    url: '/beneficiaries-verval-upload',
    method: 'get',
    params: query
  })
}
