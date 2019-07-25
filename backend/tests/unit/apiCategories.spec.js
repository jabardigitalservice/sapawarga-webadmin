import flushPromises from "flush-promises";
import nock from "nock";
import { fetchList } from "@/api/categories";
import categoriesListFixture from "./fixtures/categoriesList";

describe("API categories", () => {
  it("get list", async () => {
    const request = nock("http://localhost")
    .get("/categories")
    .reply(200, categoriesListFixture)

    const result = await fetchList()
    await flushPromises();

    expect(result).toBeDefined()
    expect(result).toEqual(categoriesListFixture)
    expect(request.isDone()).toBe(true)
  });
});
