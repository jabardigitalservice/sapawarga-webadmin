import request from '@/utils/request'

export function getKabkotaList(isAll) {
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

export function getKecamatanBpsList(parentId, isAll) {
  return request({
    url: 'areas',
    method: 'get',
    params: {
      code_bps_parent: parentId,
      depth: 3,
      all: isAll
    }
  })
}

export function getKecamatanList(parentId, isAll) {
  return request({
    url: 'areas',
    method: 'get',
    params: {
      parent_id: parentId,
      depth: 3,
      all: isAll
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
