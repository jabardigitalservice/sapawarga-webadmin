import { shallowMount, mount } from "@vue/test-utils";
import PanelGroup from "@/views/user/components/PanelGroup";
import totalUser from "../fixtures/totalUser";

describe("PanelGroup User", () => {
  let props;

  const build = () => {
    const wrapper = mount(PanelGroup, {
      propsData: props
    });
    return {
      wrapper
      /* cardColumn: () => wrapper.find('.card-panel-col'),
      cardIcon: () => wrapper.find('.card-panel-icon-wrapper.icon-people-all'),
      cardNumber: () => wrapper.find('.card-panel-description') */
    };
  };

  beforeEach(() => {
    props = {
      totalUserSummary: totalUser,
      totalAllUser: totalUser.totalUser,
      totalUserProvince: totalUser.totalUserProvince,
      totalUserKoKab: totalUser.totalUserKoKab,
      totalUserKec: totalUser.totalUserKec,
      totalUserKel: totalUser.totalUserKel,
      totalUserRw: totalUser.totalUserRw,
      totalUserRt: totalUser.totalUserRt,
      duration: 1
    };
  });

  it("renders the component", () => {
    // arrange
    const { wrapper } = build();

    // assert
    expect(wrapper.html()).toMatchSnapshot();
  });

  it("renders total all user", done => {
    // arrange
    const { wrapper } = build();
    const cardColumn = () => wrapper.find(".card-panel-col.total-all");
    const cardIcon = () =>
      wrapper.find(".card-panel-icon-wrapper.icon-people-all");
    const cardText = () => wrapper.find(".total-all").find(".card-panel-text");
    const cardNumber = () => wrapper.find(".total-all").find(".card-panel-num");

    // assert
    expect(cardColumn().exists()).toBe(true);
    expect(cardIcon().exists()).toBe(true);
    expect(cardText().exists()).toBe(true);
    expect(cardNumber().exists()).toBe(true);

    expect(cardNumber().text()).toMatch("0");
    expect(cardText().text()).toMatch("Semua");

    setTimeout(() => {
      expect(cardNumber().text()).toMatch("99");
      done();
    }, 1100);

    expect(wrapper.props().totalAllUser).toBe(totalUser.totalUser);
    // expect(name().text()).toBe(props.user.name)
  });

  it("renders total user province", done => {
    // arrange
    const { wrapper } = build();
    const mainSelector = ".total-province";
    const cardColumn = () => wrapper.find(".card-panel-col" + mainSelector);
    const cardIcon = () =>
      wrapper.find(mainSelector).find(".card-panel-icon-wrapper");
    const cardText = () => wrapper.find(mainSelector).find(".card-panel-text");
    const cardNumber = () => wrapper.find(mainSelector).find(".card-panel-num");

    // assert
    expect(cardColumn().exists()).toBe(true);
    expect(cardIcon().exists()).toBe(true);
    expect(cardText().exists()).toBe(true);
    expect(cardNumber().exists()).toBe(true);

    expect(cardNumber().text()).toMatch("0");
    expect(cardText().text()).toMatch("Provinsi");

    setTimeout(() => {
      expect(cardNumber().text()).toMatch("2");
      done();
    }, 1100);

    expect(wrapper.props().totalUserProvince).toBe(totalUser.totalUserProvince);
  });
});
