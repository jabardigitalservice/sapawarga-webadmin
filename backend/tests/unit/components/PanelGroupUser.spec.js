import { mount, createLocalVue } from "@vue/test-utils";
import PanelGroup from "@/views/user/components/PanelGroup";
import totalUser from "../fixtures/totalUser";
import ElementUI from 'element-ui';
//import SVG from '@/components/SvgIcon';
// src/components/SvgIcon/index.vue
import SvgIcon from '@/components/SvgIcon'// svg组件

// register globally

const localVue = createLocalVue()
localVue.use(ElementUI)
localVue.component('svg-icon', SvgIcon)

describe("PanelGroup User", () => {
  let props;

  const build = () => {
    const wrapper = mount(PanelGroup, {
      propsData: props,
      localVue
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
      roleId: null,
      totalUserSummary: totalUser,
      totalAllUser: totalUser.totalUser,
      totalUserProvince: totalUser.totalUserProvince,
      totalUserKabKota: totalUser.totalUserKoKab,
      totalUserKec: totalUser.totalUserKec,
      totalUserKel: totalUser.totalUserKel,
      totalUserRw: totalUser.totalUserRw,
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
    const mainSelector = ".total-all";

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
    // expect(wrapper.vm.roleId).toBeTruthy();
    expect(wrapper.props().roleId).toBe(null);

    expect(cardNumber().text()).toMatch("0");
    expect(cardText().text()).toMatch("Semua");

    setTimeout(() => {
      expect(cardNumber().text()).toMatch(totalUser.totalUser.toString());
      done();
    }, 1100);

    expect(wrapper.props().totalAllUser).toBe(totalUser.totalUser);
    // expect(name().text()).toBe(props.user.name)
  });

  it("hide total all user when role is not admin", () => {
    // arrange
    const { wrapper } = build();
    const mainSelector = ".total-all";
    wrapper.setProps({ roleId: "staffProv" });

    const cardColumn = () => wrapper.find(".card-panel-col" + mainSelector);

    expect(cardColumn().exists()).toBe(false);
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
      expect(cardNumber().text()).toMatch(
        totalUser.totalUserProvince.toString()
      );
      done();
    }, 1100);

    expect(wrapper.props().totalUserProvince).toBe(totalUser.totalUserProvince);
  });

  it("hide total all user province when role is not province", () => {
    // arrange
    const { wrapper } = build();
    const mainSelector = ".total-province";
    wrapper.setProps({ roleId: "staffKabkota" });

    const cardColumn = () => wrapper.find(".card-panel-col" + mainSelector);

    expect(cardColumn().exists()).toBe(false);
  });

  it("renders total user kota/kab", done => {
    // arrange
    const { wrapper } = build();
    const mainSelector = ".total-kota";
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
    expect(cardText().text()).toMatch("Kota/Kab");

    setTimeout(() => {
      expect(cardNumber().text()).toMatch(
        totalUser.totalUserKoKab.toString()
      );
      done();
    }, 1100);

    expect(wrapper.props().totalUserKabKota).toBe(totalUser.totalUserKoKab);
  });

  it("hide total all user kota/kab when role is not kota/kab", () => {
    // arrange
    const { wrapper } = build();
    const mainSelector = ".total-kota";
    wrapper.setProps({ roleId: "staffKec" });

    const cardColumn = () => wrapper.find(".card-panel-col" + mainSelector);

    expect(cardColumn().exists()).toBe(false);
  });

  it("renders total user kecamatan", done => {
    // arrange
    const { wrapper } = build();
    const mainSelector = ".total-kec";
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
    expect(cardText().text()).toMatch("Kecamatan");

    setTimeout(() => {
      expect(cardNumber().text()).toMatch(
        totalUser.totalUserKec.toString()
      );
      done();
    }, 1100);

    expect(wrapper.props().totalUserKec).toBe(totalUser.totalUserKec);
  });

  it("hide total all user kecamatan when role is not kecamatan", () => {
    // arrange
    const { wrapper } = build();
    const mainSelector = ".total-kec";
    wrapper.setProps({ roleId: "staffKel" });

    const cardColumn = () => wrapper.find(".card-panel-col" + mainSelector);

    expect(cardColumn().exists()).toBe(false);
  });

  it("renders total user kelurahan", done => {
    // arrange
    const { wrapper } = build();
    const mainSelector = ".total-kel";
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
    expect(cardText().text()).toMatch("Kelurahan");

    setTimeout(() => {
      expect(cardNumber().text()).toMatch(
        totalUser.totalUserKel.toString()
      );
      done();
    }, 1100);

    expect(wrapper.props().totalUserKel).toBe(totalUser.totalUserKel);
  });

  it("hide total all user kelurahan when role is not kelurahan", () => {
    // arrange
    const { wrapper } = build();
    const mainSelector = ".total-kel";
    wrapper.setProps({ roleId: "staffRW" });

    const cardColumn = () => wrapper.find(".card-panel-col" + mainSelector);

    expect(cardColumn().exists()).toBe(false);
  });

  it("renders total user RW", done => {
    // arrange
    const { wrapper } = build();
    const mainSelector = ".total-rw";
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
    expect(cardText().text()).toMatch("RW");

    setTimeout(() => {
      expect(cardNumber().text()).toMatch(
        totalUser.totalUserRw.toString()
      );
      done();
    }, 1100);

    expect(wrapper.props().totalUserRw).toBe(totalUser.totalUserRw);
  });

});
