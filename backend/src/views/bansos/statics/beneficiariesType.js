class BeneficiariesType {
  getAll(typeId) {
    const data = [
      { id: 51, type: 'dtks', name: 'DTKS - PKH' },
      { id: 52, type: 'dtks', name: 'DTKS - BPNT(Program Sembako)' },
      { id: 53, type: 'dtks', name: 'DTKS - BPNT Perluasan' },
      { id: 54, type: 'dtks', name: 'DTKS - Bansos Tunai Kemensos' },
      { id: 55, type: 'dtks', name: 'DTKS - Bansos Presiden Sembako' },
      { id: 56, type: 'dtks', name: 'DTKS - Bansos Provinsi' },
      { id: 57, type: 'dtks', name: 'DTKS - Bansos Dana Desa' },
      { id: 1, type: 'non_dtks', name: 'Non DTKS - Bansos Tunai Kemensos' },
      { id: 2, type: 'non_dtks', name: 'Non DTKS - Bansos Presiden Sembako' },
      { id: 3, type: 'non_dtks', name: 'Non DTKS - Bansos Provinsi' },
      { id: 4, type: 'non_dtks', name: 'Non DTKS - Dana Desa' },
      { id: 5, type: 'non_dtks', name: 'Non DTKS - Bansos Kota/Kabupaten' }
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
