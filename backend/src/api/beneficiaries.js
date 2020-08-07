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
    url: '/beneficiaries-bnba/summary',
    method: 'get',
    params: query
  })
}

export function fetchBnbaTahapSatuList(query) {
  return request({
    url: '/beneficiaries-bnba',
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

export function checkNik(data) {
  return request({
    url: `/beneficiaries/check-nik`,
    method: 'get',
    params: data
  })
}

export function validateKK(data) {
  return request({
    url: `/beneficiaries/check-kk`,
    method: 'get',
    params: data
  })
}

export function checkAddress(data) {
  return request({
    url: 'beneficiaries/check-address',
    method: 'get',
    params: data
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
    url: `/beneficiaries-bnba/${id}`,
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

export function fetchVervalUploadList(query) {
  return request({
    url: '/beneficiaries-verval-upload',
    method: 'get',
    params: query
  })
}

export function vervalUpload(data) {
  return request({
    url: '/beneficiaries-verval-upload/upload',
    method: 'post',
    data
  })
}

export function fetchListComplaint(query) {
  return request({
    url: '/beneficiaries-complain',
    method: 'get',
    params: query
  })
}

export function fetchDetailComplaint(id) {
  return request({
    url: `/beneficiaries-complain/${id}`,
    method: 'get'
  })
}

export function fetchBeneficiariesBnbaList(query) {
  return request({
    url: '/beneficiaries-bnba/monitoring',
    method: 'get',
    params: query
  })
}

export function downloadBeneficiariesBnba(query) {
  return request({
    url: '/beneficiaries-bnba/download',
    method: 'get',
    params: query
  })
}

export function fetchCurrentTahap(query) {
  return request({
    url: '/beneficiaries/current-tahap',
    method: 'get',
    params: query
  })
}

export function fetchDownloadStatusBnba(query) {
  return request({
    url: '/beneficiaries-bnba/download-status',
    method: 'get',
    params: query
  })
}

export function fetchDownloadStatus(query) {
  return request({
    url: '/beneficiaries/download-status',
    method: 'get',
    params: query
  })
}

export function uploadBnba(data) {
  return request({
    url: '/beneficiaries-bnba/upload',
    method: 'post',
    data
  })
}

export function fetchUploadBnbaList(query) {
  return request({
    url: '/beneficiaries-bnba/upload-histories',
    method: 'get',
    params: query
  })
}
