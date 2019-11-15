import { mount, createLocalVue } from "@vue/test-utils";
import PanelGroup from "@/views/user/components/PanelGroup";
import totalUser from "../fixtures/totalUser";
import ElementUI from "element-ui";
import { RolesUser, rolesWidget } from '@/utils/constantVariabel'
//import SVG from '@/components/SvgIcon';
// src/components/SvgIcon/index.vue
import SvgIcon from "@/components/SvgIcon"; // svg组件
import i18n from '@/lang'

// register globally

const localVue = createLocalVue();
localVue.use(ElementUI);
localVue.component("svg-icon", SvgIcon);

const totalAllUser = totalUser.data.items[0].value;
const totalUserProvince = totalUser.data.items[1].value;
const totalUserKabKota = totalUser.data.items[2].value;
const totalUserKec = totalUser.data.items[3].value;
const totalUserKel = totalUser.data.items[4].value;
const totalUserRw = totalUser.data.items[5].value;
const totalUserSaberHoax = totalUser.data.items[6].value;
const totalUserTrainer = totalUser.data.items[7].value;

describe("PanelGroup User", () => {
  let props;
  const selectorAll = ".total-all";
  const selectorUserProvince = ".total-province";
  const selectorUserKabKota = ".total-kota";
  const selectorUserKec = ".total-kec";
  const selectorUserKel = ".total-kel";
  const selectorUserRw = ".total-rw";
  const selectorUserSaberHoax = ".total-saber-hoax";
  const selectorUserTrainer = ".total-trainer";

  const build = () => {
    const wrapper = mount(PanelGroup, {
      RolesUser,
      rolesWidget,
      propsData: props,
      localVue,
      i18n
    });
    return {
      wrapper,
      cardColumnAllUser: () => wrapper.find(".card-panel-col" + selectorAll),
      cardIconAllUser: () => wrapper.find(selectorAll).find(".card-panel-icon-wrapper"),
      cardTextAllUser: () => wrapper.find(selectorAll).find(".card-panel-text"),
      cardNumberAllUser: () => wrapper.find(selectorAll).find(".card-panel-num"),
      cardColumnUserProvince: () =>
        wrapper.find(".card-panel-col" + selectorUserProvince),
      cardIconUserProvince: () =>
        wrapper.find(selectorUserProvince).find(".card-panel-icon-wrapper"),
      cardTextUserProvince: () =>
        wrapper.find(selectorUserProvince).find(".card-panel-text"),
      cardNumberUserProvince: () =>
        wrapper.find(selectorUserProvince).find(".card-panel-num"),
      cardColumnUserKabKota: () =>
        wrapper.find(".card-panel-col" + selectorUserKabKota),
      cardIconUserKabKota: () =>
        wrapper.find(selectorUserKabKota).find(".card-panel-icon-wrapper"),
      cardTextUserKabKota: () =>
        wrapper.find(selectorUserKabKota).find(".card-panel-text"),
      cardNumberUserKabKota: () =>
        wrapper.find(selectorUserKabKota).find(".card-panel-num"),
      cardColumnUserKec: () =>
        wrapper.find(".card-panel-col" + selectorUserKec),
      cardIconUserKec: () =>
        wrapper.find(selectorUserKec).find(".card-panel-icon-wrapper"),
      cardTextUserKec: () =>
        wrapper.find(selectorUserKec).find(".card-panel-text"),
      cardNumberUserKec: () =>
        wrapper.find(selectorUserKec).find(".card-panel-num"),
      cardColumnUserKel: () =>
        wrapper.find(".card-panel-col" + selectorUserKel),
      cardIconUserKel: () =>
        wrapper.find(selectorUserKel).find(".card-panel-icon-wrapper"),
      cardTextUserKel: () =>
        wrapper.find(selectorUserKel).find(".card-panel-text"),
      cardNumberUserKel: () =>
        wrapper.find(selectorUserKel).find(".card-panel-num"),
      cardColumnUserRw: () => wrapper.find(".card-panel-col" + selectorUserRw),
      cardIconUserRw: () =>
        wrapper.find(selectorUserRw).find(".card-panel-icon-wrapper"),
      cardTextUserRw: () =>
        wrapper.find(selectorUserRw).find(".card-panel-text"),
      cardNumberUserRw: () =>
        wrapper.find(selectorUserRw).find(".card-panel-num"),
      cardColumnUserSaberHoax: () => wrapper.find(".card-panel-col" + selectorUserSaberHoax),
      cardIconUserSaberHoax: () =>
        wrapper.find(selectorUserSaberHoax).find(".card-panel-icon-wrapper"),
      cardTextUserSaberHoax: () =>
        wrapper.find(selectorUserSaberHoax).find(".card-panel-text"),
      cardNumberUserSaberHoax: () =>
        wrapper.find(selectorUserSaberHoax).find(".card-panel-num"),
      cardColumnUserTrainer: () => wrapper.find(".card-panel-col" + selectorUserTrainer),
      cardIconUserTrainer: () =>
        wrapper.find(selectorUserTrainer).find(".card-panel-icon-wrapper"),
      cardTextUserTrainer: () =>
        wrapper.find(selectorUserTrainer).find(".card-panel-text"),
      cardNumberUserTrainer: () =>
        wrapper.find(selectorUserTrainer).find(".card-panel-num")
    };
  };

  beforeEach(() => {
    props = {
      roleId: 'admin',
      pages: 'all',
      rolesWidget: RolesUser,
      RolesUser: rolesWidget,
      totalAllUser: totalAllUser,
      totalUserProvince: totalUserProvince,
      totalUserKabKota: totalUserKabKota,
      totalUserKec: totalUserKec,
      totalUserKel: totalUserKel,
      totalUserRw: totalUserRw,
      totalUserSaberHoax: totalUserSaberHoax,
      totalUserTrainer: totalUserTrainer,
      duration: 1
    };
  });

  it("renders the component", () => {
    // arrange
    const { wrapper } = build();

    // assert
    expect(wrapper.html()).toMatchSnapshot();
  });

  it("renders all card", done => {
    // arrange
    const {
      wrapper,
      cardColumnAllUser,
      cardIconAllUser,
      cardTextAllUser,
      cardNumberAllUser,
      cardColumnUserProvince,
      cardIconUserProvince,
      cardTextUserProvince,
      cardNumberUserProvince,
      cardColumnUserKabKota,
      cardIconUserKabKota,
      cardTextUserKabKota,
      cardNumberUserKabKota,
      cardColumnUserKec,
      cardIconUserKec,
      cardTextUserKec,
      cardNumberUserKec,
      cardColumnUserKel,
      cardIconUserKel,
      cardTextUserKel,
      cardNumberUserKel,
      cardColumnUserRw,
      cardIconUserRw,
      cardTextUserRw,
      cardNumberUserRw,
      cardColumnUserSaberHoax,
      cardIconUserSaberHoax,
      cardTextUserSaberHoax,
      cardNumberUserSaberHoax,
      cardColumnUserTrainer,
      cardIconUserTrainer,
      cardTextUserTrainer,
      cardNumberUserTrainer
    } = build();

    // assert
    expect(wrapper.props().roleId).toBe("admin");
    expect(cardColumnAllUser().exists()).toBe(true);
    expect(cardIconAllUser().exists()).toBe(true);
    expect(cardTextAllUser().exists()).toBe(true);
    expect(cardNumberAllUser().exists()).toBe(true);
    // expect(wrapper.vm.roleId).toBeTruthy();
    expect(cardColumnUserProvince().exists()).toBe(true);
    expect(cardIconUserProvince().exists()).toBe(true);
    expect(cardTextUserProvince().exists()).toBe(true);
    expect(cardNumberUserProvince().exists()).toBe(true);
    expect(cardColumnUserKabKota().exists()).toBe(true);
    expect(cardIconUserKabKota().exists()).toBe(true);
    expect(cardTextUserKabKota().exists()).toBe(true);
    expect(cardNumberUserKabKota().exists()).toBe(true);
    expect(cardColumnUserKec().exists()).toBe(true);
    expect(cardIconUserKec().exists()).toBe(true);
    expect(cardTextUserKec().exists()).toBe(true);
    expect(cardNumberUserKec().exists()).toBe(true);
    expect(cardColumnUserKel().exists()).toBe(true);
    expect(cardIconUserKel().exists()).toBe(true);
    expect(cardTextUserKel().exists()).toBe(true);
    expect(cardNumberUserKel().exists()).toBe(true);
    expect(cardColumnUserRw().exists()).toBe(true);
    expect(cardIconUserRw().exists()).toBe(true);
    expect(cardTextUserRw().exists()).toBe(true);
    expect(cardNumberUserRw().exists()).toBe(true);
    expect(cardColumnUserSaberHoax().exists()).toBe(true);
    expect(cardIconUserSaberHoax().exists()).toBe(true);
    expect(cardTextUserSaberHoax().exists()).toBe(true);
    expect(cardNumberUserSaberHoax().exists()).toBe(true);
    expect(cardColumnUserTrainer().exists()).toBe(true);
    expect(cardIconUserTrainer().exists()).toBe(true);
    expect(cardTextUserTrainer().exists()).toBe(true);
    expect(cardNumberUserTrainer().exists()).toBe(true);
    expect(cardNumberAllUser().text()).toMatch("0");
    expect(cardTextAllUser().text()).toMatch("Semua");
    expect(cardNumberUserProvince().text()).toMatch("0");
    expect(cardTextUserProvince().text()).toMatch("Provinsi");
    expect(cardNumberUserKabKota().text()).toMatch("0");
    expect(cardTextUserKabKota().text()).toMatch("Kota/Kab");
    expect(cardNumberUserKec().text()).toMatch("0");
    expect(cardTextUserKec().text()).toMatch("Kecamatan");
    expect(cardNumberUserKel().text()).toMatch("0");
    expect(cardTextUserKel().text()).toMatch("Desa/Kel");
    expect(cardNumberUserRw().text()).toMatch("0");
    expect(cardTextUserRw().text()).toMatch("RW");
    expect(cardTextUserSaberHoax().text()).toMatch("Saber Hoax");
    expect(cardNumberUserSaberHoax().text()).toMatch("0");
    expect(cardTextUserSaberHoax().text()).toMatch("Saber Hoax");
    expect(cardTextUserTrainer().text()).toMatch("Pelatih");
    expect(cardNumberUserTrainer().text()).toMatch("0");
    expect(cardTextUserTrainer().text()).toMatch("Pelatih");
    setTimeout(() => {
      expect(cardNumberAllUser().text()).toMatch(totalAllUser.toString());
      expect(cardNumberUserProvince().text()).toMatch(
        totalUserProvince.toString()
      );
      expect(cardNumberUserKabKota().text()).toMatch(
        totalUserKabKota.toString()
      );
      expect(cardNumberUserKec().text()).toMatch(totalUserKec.toString());
      expect(cardNumberUserKel().text()).toMatch(totalUserKel.toString());
      expect(cardNumberUserRw().text()).toMatch(totalUserRw.toString());
      expect(cardNumberUserSaberHoax().text()).toMatch(totalUserSaberHoax.toString());
      expect(cardNumberUserTrainer().text()).toMatch(totalUserTrainer.toString());
      done();
    }, 1100);

    expect(wrapper.props().totalAllUser).toBe(totalAllUser);
    expect(wrapper.props().totalUserProvince).toBe(totalUserProvince);
    expect(wrapper.props().totalUserKabKota).toBe(totalUserKabKota);
    expect(wrapper.props().totalUserKec).toBe(totalUserKec);
    expect(wrapper.props().totalUserKel).toBe(totalUserKel);
    expect(wrapper.props().totalUserRw).toBe(totalUserRw);
    expect(wrapper.props().totalUserSaberHoax).toBe(totalUserSaberHoax);
    expect(wrapper.props().totalUserTrainer).toBe(totalUserTrainer);
    // expect(name().text()).toBe(props.user.name)
  });

  it("hide total all user when role is not admin", () => {
    // arrange
    const { wrapper } = build();
    const mainSelector = ".total-all";
    wrapper.setProps({ roleId: "staffProv" });

    const cardColumn = () => wrapper.find(".card-panel-col" + mainSelector);

    expect(cardColumn().exists()).toBe(true);
  });

  it("hide total all user province when role is not province", () => {
    // arrange
    const { wrapper } = build();
    const mainSelector = ".total-province";
    wrapper.setProps({ roleId: "staffKabkota" });

    const cardColumn = () => wrapper.find(".card-panel-col" + mainSelector);

    expect(cardColumn().exists()).toBe(false);
  });

  it("hide total all user kota/kab when role is not kota/kab", () => {
    // arrange
    const { wrapper } = build();
    const mainSelector = ".total-kota";
    wrapper.setProps({ roleId: "staffKec" });

    const cardColumn = () => wrapper.find(".card-panel-col" + mainSelector);

    expect(cardColumn().exists()).toBe(false);
  });

  it("hide total all user kecamatan when role is not kecamatan", () => {
    // arrange
    const { wrapper } = build();
    const mainSelector = ".total-kec";
    wrapper.setProps({ roleId: "staffKel" });

    const cardColumn = () => wrapper.find(".card-panel-col" + mainSelector);

    expect(cardColumn().exists()).toBe(false);
  });

  it("hide total all user kelurahan when role is not kelurahan", () => {
    // arrange
    const { wrapper } = build();
    const mainSelector = ".total-kel";
    wrapper.setProps({ roleId: "staffRW" });

    const cardColumn = () => wrapper.find(".card-panel-col" + mainSelector);

    expect(cardColumn().exists()).toBe(false);
  });

  it("hide total all user saber hoax when role is not saber hoax", () => {
    // arrange
    const { wrapper } = build();
    const mainSelector = ".total-saber-hoax";
    wrapper.setProps({ roleId: "saberHoax" });

    const cardColumn = () => wrapper.find(".card-panel-col" + mainSelector);

    expect(cardColumn().exists()).toBe(false);
  });

  it("hide total all user trainer when role is not trainer", () => {
    // arrange
    const { wrapper } = build();
    const mainSelector = ".total-saber-trainer";
    wrapper.setProps({ roleId: "trainer" });

    const cardColumn = () => wrapper.find(".card-panel-col" + mainSelector);

    expect(cardColumn().exists()).toBe(false);
  });
});
