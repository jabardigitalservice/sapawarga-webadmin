import axios from 'axios'

export async function getLink(kabkotaCode) {
  const { data } = await axios.get('https://v2-api.sheety.co/0a4816ada0d92ef8a943f30207e40e1e/bnbaPenerimaBantuanSosialNonDtks/documents')

  // eslint-disable-next-line eqeqeq
  const record = data.documents.find(e => e.kode == kabkotaCode)

  return record['link']
}
