import moment from 'moment'

export function parsingDatetime(datetime, format) {
  if (format) {
    datetime = moment(datetime * 1000).format(format)
  } else {
    datetime = moment(datetime * 1000).format('DD MMMM YYYY HH:mm')
  }
  return datetime
}

export function formatDatetime(datetime, format) {
  datetime = moment(datetime).format(format)
  return datetime
}
