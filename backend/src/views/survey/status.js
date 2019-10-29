import moment from 'moment'

export function getStatusColor(row) {
  const now = moment()
  const startDate = moment(row.start_date).startOf('day')
  const endDate = moment(row.end_date).endOf('day')

  const isRunning = now.isBetween(startDate, endDate, null, '[]')

  if (row.status === 10 && isRunning) {
    return 'success'
  }

  if (row.status === 10 && now.isAfter(endDate)) {
    return 'warning'
  }

  if (row.status === 1) {
    return 'danger'
  }

  if (row.status === 0) {
    return 'info'
  }

  return row.status_label
}

export function getStatusLabel(row) {
  const now = moment()
  const startDate = moment(row.start_date).startOf('day')
  const endDate = moment(row.end_date).endOf('day')

  const isRunning = now.isBetween(startDate, endDate, null, '[]')

  if (row.status === 10 && isRunning) {
    return 'Sedang Berlangsung'
  }

  if (row.status === 10 && now.isAfter(endDate)) {
    return 'Berakhir'
  }

  return row.status_label
}

export const SurveyStatus = Object.freeze({
  DRAFT: 0,
  ACTIVE: 10
})
