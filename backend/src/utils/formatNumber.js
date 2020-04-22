export function formatNumber(number) {
  if (number === null) {
    return ''
  }

  const transform = Intl.NumberFormat().format(parseFloat(number))
  return transform.replace(/,/g, '.')
}
