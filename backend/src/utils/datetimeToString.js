import moment from 'moment'

export default function parsingDatetime(datetime) {
  datetime = moment(datetime * 1000).format('DD MMMM YYYY HH:mm')
  return datetime
}
