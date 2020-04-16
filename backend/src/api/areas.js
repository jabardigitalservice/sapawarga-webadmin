import request from '@/utils/request'

export function getKabkotaList() {
  return request({
    url: 'areas',
    method: 'get',
    params: {
      parent_id: 1,
      depth: 2,
      all: true
    }
  })
}

export function getKecamatanBpsList(parentId) {
  return request({
    url: 'areas',
    method: 'get',
    params: {
      code_bps_parent: parentId,
      depth: 3,
      all: true
    }
  })
}

export function getKecamatanList(parentId) {
  return request({
    url: 'areas',
    method: 'get',
    params: {
      parent_id: parentId,
      depth: 3,
      all: true
    }
  })
}

export function getKelurahanBpsList(parentId, isAll) {
  return request({
    url: 'areas',
    method: 'get',
    params: {
      code_bps_parent: parentId,
      depth: 4,
      all: isAll
    }
  })
}

export function getKelurahanList(parentId, isAll) {
  return request({
    url: 'areas',
    method: 'get',
    params: {
      parent_id: parentId,
      depth: 4,
      all: isAll
    }
  })
}
