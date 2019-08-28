import flushPromises from 'flush-promises'
import nock from 'nock'
// import { fetchList } from '@/api/news'
import { fetchAspirasiMap } from '@/api/dashboard'
// import newsApi from '@/api/news'
// import newsListFixture from './fixtures/newsList'
// import newsDetailFixture from './fixtures/newsDetail'

import usulanGeoFixture from './fixtures/usulanGeo'

describe('API Dashboard', () => {
  it('get list usulan geo', async () => {
    const request = nock('http://localhost')
      .get('/dashboards/aspirasi-geo')
      .reply(200, usulanGeoFixture)

    const result = await fetchAspirasiMap()
    await flushPromises()

    // assert
    expect(result).toBeDefined()
    expect(result).toEqual(usulanGeoFixture)
    expect(request.isDone()).toBe(true)
  })
})
