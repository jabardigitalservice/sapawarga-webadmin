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

export const PollingStatus = Object.freeze({
  INACTIVE: 'Tidak Aktif',
  END: 'Berakhir',
  LIVE: 'Sedang Berlangsung',
  PUBLISHED: 'Dipublikasikan'
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
  NEWS: 'news',
  NEWS_IMPORTANT: 'news-important',
  GAMIFICATION: 'gamification'
})

export const RolesUser = Object.freeze({
  ADMIN: 'admin',
  LEADER: 'pimpinan',
  STAFFOPD: 'staffOPD',
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
  'user': ['admin', 'staffProv', 'user'],
  'pimpinan': ['admin', 'staffProv', 'pimpinan'],
  'staffKelOPD': ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel', 'staffOPD']
}

export const UrlDownloadImportData = `${process.env.VUE_APP_S3_URL}attachment/Template_Data_Manual.xlsx`

export const CODE_BPS_SUMEDANG = '3211'
export const CODE_BPS_BANDUNG = '3273'

export const HOTLINE_SW = 'https://s.id/HotlineSW'

// add kabkota code_bps
// export const KAB_KOTA_ACCESS_BNBA = [
//   'admin',
//   '3279', // kota banjar
//   '3277', // kota cimahi
//   '3274', // kota cirebon
//   '3272', // kota sukabumi
//   '3276', // kota depok
//   '3214', // kab. purwakarta
//   '3275', // kota bekasi
//   '3271', // kota bogor
//   '3211', // kab. sumedang
//   '3218', // kab. pangandaran
//   '3215' // kab. karawang
// ]

export const RemoteConfigKey = Object.freeze({
  BANNERS: 'banners'
})
