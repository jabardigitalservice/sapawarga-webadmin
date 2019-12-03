import request from '@/utils/request'

export function fetchListQuestions(query) {
  return request({
    url: 'http://52.74.74.33:3000/v1/questions',
    method: 'get',
    params: query
  })
}

export function fetchDetailQuestions(id) {
  return request({
    url: `http://52.74.74.33:3000/v1/questions/${id}`,
    method: 'get'
  })
}

export function fetchListAnswer(id) {
  return request({
    url: `http://52.74.74.33:3000/v1/questions/${id}/comments`,
    method: 'get'
  })
}

export function postAnswer(id, data) {
  return request({
    url: `http://52.74.74.33:3000/v1/questions/${id}/comments`,
    method: 'post',
    data
  })
}
