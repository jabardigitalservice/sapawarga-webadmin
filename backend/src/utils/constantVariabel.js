export const ResponseRequest = Object.freeze({
  TIMEOUT: 'ECONNABORTED',
  NETWORKERROR: 'Network Error',
  SERVERERROR: 500,
  NOTFOUND: 404,
  FORBIDDEN: 403,
  UNPROCESSABLE: 422
})

// status
export const SurveyStatus = Object.freeze({
  DRAFT: 0,
  ACTIVE: 10
})

export const AspirationStatus = Object.freeze({
  PUBLISH: 10,
  UNPUBLISH: 7,
  REJECT: 3,
  SENT: 5
})

export const PopupCategory = Object.freeze({
  EXTERNAL: 'external',
  INTERNAL: 'internal'
})

export const PopupFeature = Object.freeze({
  SURVEY: 'survey',
  POLLING: 'polling',
  NEWS: 'news'
})

export const RolesUser = Object.freeze({
  ADMIN: 'admin',
  STAFFPROV: 'staffProv',
  STAFFKABKOTA: 'staffKabkota',
  STAFFKEC: 'staffKec',
  STAFFKEL: 'staffKel',
  STAFFRW: 'staffRW',
  STAFFSABERHOAX: 'staffSaberhoax',
  TRAINER: 'trainer',
  PUBLIK: 'user'
})

export const rolesWidget = {
  ALL: 'all',
  'staffProv': ['admin', 'staffProv'],
  'staffKabkota': ['admin', 'staffProv', 'staffKabkota'],
  'staffKec': ['admin', 'staffProv', 'staffKabkota', 'staffKec'],
  'staffKel': ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel'],
  'staffRW': ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel', 'staffRW'],
  'staffSaberhoax': ['admin', 'staffSaberhoax'],
  'trainer': ['admin', 'staffProv', 'trainer'],
  'user': ['admin', 'staffProv', 'user']
}
