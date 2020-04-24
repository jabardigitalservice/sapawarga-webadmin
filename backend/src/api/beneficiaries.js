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

// ambil data penerima bantuan PKH
export function fetchListGetPKH(query) {
  return new Promise(resolve => {
    resolve({"success":true,"status":200,"data":{"items":[{"id":1219522,"nik":"3201120903810009","no_kk":"32011209","name":" \tINDRA MAHMUDI","province_bps_id":"32","kabkota_bps_id":"3271","kec_bps_id":"3271060","kel_bps_id":"3271060002","province_id":null,"kabkota_id":null,"kec_id":null,"kel_id":null,"province":{"id":1,"code_bps":"32","name":"JAWA BARAT"},"kabkota":{"id":20,"code_bps":"3271","name":"KOTA BOGOR"},"kecamatan":{"id":417,"code_bps":"3271060","name":"TANAH SAREAL"},"kelurahan":{"id":6002,"code_bps":"3271060002","name":"KEDUNG JAYA"},"rt":"1","rw":"2","address":"CIMANGGU GANG H. ENUNG NO. 55","domicile_province_bps_id":"32","domicile_kabkota_bps_id":"3271","domicile_kec_bps_id":"3271060","domicile_kel_bps_id":null,"domicile_kabkota_name":{"code_bps":"3271","name":"KOTA BOGOR"},"domicile_kec_name":{"code_bps":"3271060","name":"TANAH SAREAL"},"domicile_kel_name":null,"domicile_rt":null,"domicile_rw":"2","domicile_address":"CIMANGGU GANG H. ENUNG NO. 55 RT 001 RW 002","phone":"No Hp. 0895604499917 RT","total_family_members":0,"job_type_id":21,"job_status_id":null,"job_type_name":{"id":21,"title":"Lainnya","seq":99},"job_status_name":null,"income_before":0,"income_after":0,"image_ktp":null,"image_kk":null,"image_ktp_url":null,"image_kk_url":null,"is_need_help":null,"is_poor_new":null,"notes":null,"notes_approved":null,"notes_rejected":null,"status_verification":1,"status_verification_label":"Belum Terverifikasi","status":10,"status_label":"Aktif","created_at":1587402491,"updated_at":1587402491,"created_by":2},{"id":147202,"nik":"3275120506670009","no_kk":"3275120","name":"Fulan","province_bps_id":"32","kabkota_bps_id":"3275","kec_bps_id":"3275012","kel_bps_id":"3275012003","province_id":null,"kabkota_id":null,"kec_id":null,"kel_id":null,"province":{"id":1,"code_bps":"32","name":"JAWA BARAT"},"kabkota":{"id":23,"code_bps":"3275","name":"KOTA BEKASI"},"kecamatan":{"id":449,"code_bps":"3275012","name":"PONDOKMELATI"},"kelurahan":{"id":6197,"code_bps":"3275012003","name":"JATIWARNA"},"rt":"3","rw":"1","address":"KP. SAWAH","domicile_province_bps_id":"32","domicile_kabkota_bps_id":"3275","domicile_kec_bps_id":null,"domicile_kel_bps_id":null,"domicile_kabkota_name":{"code_bps":"3275","name":"KOTA BEKASI"},"domicile_kec_name":null,"domicile_kel_name":null,"domicile_rt":null,"domicile_rw":null,"domicile_address":null,"phone":null,"total_family_members":0,"job_type_id":21,"job_status_id":null,"job_type_name":{"id":21,"title":"Lainnya","seq":99},"job_status_name":null,"income_before":0,"income_after":0,"image_ktp":null,"image_kk":null,"image_ktp_url":null,"image_kk_url":null,"is_need_help":null,"is_poor_new":null,"notes":null,"notes_approved":null,"notes_rejected":null,"status_verification":1,"status_verification_label":"Belum Terverifikasi","status":10,"status_label":"Aktif","created_at":1587402491,"updated_at":1587402491,"created_by":2}],"_links":{"self":{"href":"http://sapawarga-staging.jabarprov.go.id/v1/beneficiaries?sort_by=name&sort_order=ascending&page=1&limit=10&per-page=10"},"next":{"href":"http://sapawarga-staging.jabarprov.go.id/v1/beneficiaries?sort_by=name&sort_order=ascending&page=2&limit=10&per-page=10"},"last":{"href":"http://sapawarga-staging.jabarprov.go.id/v1/beneficiaries?sort_by=name&sort_order=ascending&page=284994&limit=10&per-page=10"}},"_meta":{"totalCount":2,"pageCount":1,"currentPage":1,"perPage":10}}})
  })
}
