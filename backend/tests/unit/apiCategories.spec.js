import flushPromises from 'flush-promises'
import nock from 'nock'
import { fetchList, fetchRecord, fetchTypes, create } from '@/api/categories'
import categoriesListFixture from './fixtures/categoriesList'
import categoriesDetailFixture from './fixtures/categoriesDetail'
import categoriesCreateResponse from './fixtures/categoriesCreateResponse'

describe('API categories', () => {
  it('get list', async() => {
    const request = nock('http://localhost')
      .get('/categories')
      .reply(200, categoriesListFixture)

    const result = await fetchList()
    await flushPromises()

    expect(result).toBeDefined()
    expect(result).toEqual(categoriesListFixture)
    expect(request.isDone()).toBe(true)
  })

  it('get one', async() => {
    const id = 2
    const expectedOne = categoriesListFixture
    expectedOne.data.items.splice(0, 6)

    const request = nock('http://localhost')
      .get(`/categories/${id}`)
      .reply(200, categoriesDetailFixture)

    const result = await fetchRecord(id)
    await flushPromises()

    expect(result).toBeDefined()
    expect(result).toEqual(categoriesDetailFixture)
    expect(request.isDone()).toBe(true)
  })

  it('get types', async() => {
    const categoriesTypesFixture = {
      "success": true,
      "status": 200,
      "data": {
        "items": [
          {
            "id": "phonebook",
            "name": "Phone Book",
            "created_at": 1557808385,
            "updated_at": 1557808385
          },
          {
            "id": "broadcast",
            "name": "Broadcast",
            "created_at": 15578083856,
            "updated_at": 15578083856
          }
        ]
      }
    }

    const request = nock('http://localhost')
      .get('/categories/types')
      .reply(200, categoriesTypesFixture)

    const result = await fetchTypes()
    await flushPromises()

    expect(result).toBeDefined()
    expect(result).toEqual(categoriesTypesFixture)
    expect(request.isDone()).toBe(true)
  })

  it('create', async() => {
    const request = nock('http://localhost')
      .post(`/categories`)
      .reply(200, categoriesCreateResponse)

    const result = await create({
      'type': 'phonebook',
      'name': 'Category Name',
      'status': 10
    })
    await flushPromises()

    expect(result).toBeDefined()
    expect(result).toEqual(categoriesCreateResponse)
    expect(request.isDone()).toBe(true)
  })
})
