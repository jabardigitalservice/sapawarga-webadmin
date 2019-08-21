import { shallowMount, createLocalVue, mount } from "@vue/test-utils";
import DashboardUsulan from "@/views/dashboard/admin/components/Usulan";
import DashboardApproval from "@/views/dashboard/admin/components/Approval";
import ListFilter from "@/views/dashboard/admin/components/_listfilter";
import ElementUI from "element-ui";

const localVue = createLocalVue();
localVue.use(ElementUI);

beforeEach(() => {
  jest.resetModules();
  jest.clearAllMocks();
});

describe("List dashboard usulan", () => {
  it("render list usulan", () => {
    const wrapper = shallowMount(DashboardUsulan, {
      localVue
    });

    wrapper.vm.getList()
    wrapper.vm.resetFilter()

    expect(wrapper.contains(ListFilter)).toBe(true)
  });

  it("render _listfilter", () => {
    const listQuery = {
      category_id: null,
      kabkota_id: null
    }
    
    const wrapper = shallowMount(ListFilter, {
      localVue,
      propsData: {
        listQuery
      }
    })

    wrapper.vm.submitSearch()
    wrapper.vm.resetFilter()
    wrapper.vm.getArea()
    
    expect(wrapper.props("listQuery")).toBe(listQuery);
    expect(wrapper.emitted()['submit-search']).toBeTruthy();
    expect(wrapper.emitted()['reset-search']).toBeTruthy();
  });

  it("render dashboard approval", () => {
    const wrapper = shallowMount(DashboardApproval, {
      localVue
    });

    expect(wrapper.is(DashboardApproval)).toBe(true)
  })
});