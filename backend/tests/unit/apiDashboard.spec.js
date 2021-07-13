import flushPromises from 'flush-promises'
// import nock from 'nock'
import * as api from '@/api/dashboard'
import { fetchAspirasiMap } from '@/api/dashboard'

import usulanGeoFixture from './fixtures/usulanGeo'

beforeEach(() => {
  jest.resetModules()
  jest.clearAllMocks()
})

jest.mock('@/api/dashboard')

describe('API Dashboard', () => {
  it('get list usulan geo', async() => {
    // const request = nock('http://localhost')
    //   .get('/dashboards/aspirasi-geo')
    //   .reply(200, usulanGeoFixture)
    api.fetchAspirasiMap = () => Promise.resolve(usulanGeoFixture)

    const result = await fetchAspirasiMap()
    await flushPromises()

    // assert
    expect(result).toBeDefined()
    expect(result).toEqual(usulanGeoFixture)
    // expect(request.isDone()).toBe(true)
  })
})
