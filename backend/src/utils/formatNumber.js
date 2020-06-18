export function formatNumber(number) {
  if (number === null) {
    return ''
  }

  const transform = Intl.NumberFormat().format(parseFloat(number))
  return transform.replace(/,/g, '.')
}

export function formatCurrency(value, prefix) {
  if (value) {
    const number_string = value.toString()
    const split = number_string.split(',')
    const modulo = split[0].length % 3
    let rupiah = split[0].substr(0, modulo)
    const thousand = split[0].substr(modulo).match(/\d{3}/gi)

    if (thousand) {
      const separator = modulo ? '.' : ''
      rupiah += separator + thousand.join('.')
    }

    rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah
    return prefix === undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '')
  } else {
    return 'Rp. 0'
  }
}
