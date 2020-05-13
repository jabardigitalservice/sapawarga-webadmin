import i18n from '@/lang'

class BeneficiariesType {
  getAll(typeId) {
    const data = [
      { id: 51, type: 'dtks', name: i18n.t('label.beneficiaries-pkh') },
      { id: 52, type: 'dtks', name: i18n.t('label.beneficiaries-bpnt-basicfood') },
      { id: 53, type: 'dtks', name: i18n.t('label.beneficiaries-bpnt-expansion') },
      { id: 54, type: 'dtks', name: i18n.t('label.beneficiaries-kemensos') },
      { id: 55, type: 'dtks', name: i18n.t('label.beneficiaries-president') },
      { id: 56, type: 'dtks', name: i18n.t('label.beneficiaries-province') },
      { id: 57, type: 'dtks', name: i18n.t('label.beneficiaries-village-fund') },
      { id: 1, type: 'non_dtks', name: i18n.t('label.beneficiaries-kemensos') },
      { id: 2, type: 'non_dtks', name: i18n.t('label.beneficiaries-president') },
      { id: 3, type: 'non_dtks', name: i18n.t('label.beneficiaries-province') },
      { id: 4, type: 'non_dtks', name: i18n.t('label.beneficiaries-village-fund') },
      { id: 5, type: 'non_dtks', name: i18n.t('label.beneficiaries-province') }
    ]

    let results = null

    if (typeId) {
      typeId = Number(typeId)
      const valueObject = data.filter(value => {
        if (value.id === typeId) {
          return value.name
        }
      })

      if (valueObject.length > 0) {
        results = valueObject[0]
      }
    } else {
      results = data
    }
    return results
  }
}

export { BeneficiariesType as default }
