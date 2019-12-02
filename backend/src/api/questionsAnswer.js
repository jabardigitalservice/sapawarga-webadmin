import request from '@/utils/request'

export function fetchListQuestions(query) {
  return request({
    url: '/questions',
    method: 'get',
    params: query
  })
}

export function fetchDetailQuestions(id) {
  return request({
    url: `/questions/${id}`,
    method: 'get'
  })
}

export function fetchListAnswer(id) {
  return request({
    url: `/questions/${id}/comments`,
    method: 'get'
  })
}

export function postAnswer(id, data) {
  return request({
    url: `/questions/${id}/comments`,
    method: 'post',
    data
  })
}
