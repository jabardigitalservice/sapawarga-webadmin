import flushPromises from "flush-promises"
import nock from "nock"
import { fetchList, fetchRecord } from "@/api/news"
import newsListFixture from "./fixtures/newsList"

describe("API News", () => {

  it("get list news", async () => {
    const request = nock("http://localhost")
      .get("/news")
      .reply(200, newsListFixture)

    const result = await fetchList()
    await flushPromises();

    // assert
    expect(result).toBeDefined()
    expect(result).toEqual(newsListFixture)
    expect(request.isDone()).toBe(true)
  });

  it('get one news', async () => {
    const idNews = 2
    const expectedOneNews = newsListFixture
    expectedOneNews.data.items.splice(0, 1)

    const request = nock("http://localhost")
    .get(`/news/${idNews}`)
    .reply(200, expectedOneNews)

    const result = await fetchRecord(idNews)
    await flushPromises()

    expect(result).toBeDefined()
    expect(result).toEqual(expectedOneNews)
    expect(request.isDone()).toBe(true)
  })
});
