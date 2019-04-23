import flushPromises from "flush-promises";
import nock from "nock";
import { countUser } from "@/api/staff";
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
    const result = await countUser();
    await flushPromises();

    // assert
    expect(result).toBeDefined();
    expect(result.data.items[0].value).toEqual(expectedAllUser);
    expect(result).toEqual(totalUserFixture)
    expect(request.isDone()).toBe(true);
  });
});
