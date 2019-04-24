import flushPromises from "flush-promises";
import nock from "nock";
import { totalUser } from "@/api/staff";
import totalUserFixture from "./fixtures/totalUser";

describe("API Staff", () => {

  it("get total all user, all role", async () => {
    // arrange
    const expectedAllUser = 32;

    // http://{{host}}/api/v1/staff/count
    const request = nock("http://localhost")
      .get("/staff/count")
      .reply(200, totalUserFixture);

    // act
    const result = await totalUser();
    await flushPromises();

    // assert
    expect(result).toBeDefined();
    expect(result.data.items[0].value).toEqual(expectedAllUser);
    expect(result).toEqual(totalUserFixture)
    expect(request.isDone()).toBe(true);
  });

  it('get total user, using province role', async () => {
    // abc.data.items.splice(1, 1)
    // arrange
    const expectedCount = 31
    const totalUserFixtureProvince = totalUserFixture
    totalUserFixtureProvince.data.items.splice(0, 1) // remove total all user
    const request = nock("http://localhost")
      .get("/staff/count")
      .reply(200, totalUserFixtureProvince);

    // act
    const result = await totalUser();
    await flushPromises();

    // assert
    expect(result).toBeDefined();
    expect(result.data.items[0].value).toEqual(expectedCount);
    expect(result).toEqual(totalUserFixtureProvince)
    expect(request.isDone()).toBe(true);
  })
});
