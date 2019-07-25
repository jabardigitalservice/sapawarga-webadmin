import { shallowMount, createLocalVue, shallow, mount } from "@vue/test-utils";
import ElementUI from "element-ui";
import BroadcastList from "@/views/broadcast/list";
import ListFilter from "@/views/broadcast/_listfilter";

const localVue = createLocalVue();
localVue.use(ElementUI);

beforeEach(() => {
  // Clear all instances and calls to constructor and all methods:
  jest.resetModules();
  jest.clearAllMocks();
});

describe("News List", () => {
  it("renders channel statistic", () => {
    const channel = [
      { title: "humas jabar", content: 50 },
      { title: "kompas", content: 20 },
      { title: "Tempo", content: 10 }
    ];

    const wrapper = shallowMount(BroadcastList, {
      localVue
    });
    expect(wrapper.contains(ListFilter)).toBe(true);
  });

  it("renders _listfilter", () => {
    const listQuery = {
      title: null,
      sort_by: "updated_at",
      sort_order: "descending",
      page: 1,
      limit: 10,
      status: null,
      kabkota_id: null,
      kec_id: null,
      kel_id: null
    }
    
    const wrapper = shallowMount(ListFilter, {
      localVue,
      propsData: {
        listQuery
      },
      mocks: {
        $store: {
          state: {
            user: {"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NjM0NjU4NzksImlzcyI6Imh0dHA6XC9cLzM1LjI0Ny4xMzUuOTMueGlwLmlvOjgxIiwiYXVkIjoiaHR0cDpcL1wvMzUuMjQ3LjEzNS45My54aXAuaW86ODEiLCJuYmYiOjE1NjM0NjU4NzksImV4cCI6MTU2MzU1MjI3OSwiZGF0YSI6eyJ1c2VybmFtZSI6InN0YWZma2Fia290YSIsInJvbGVMYWJlbCI6IlN0YWYgS2FidXBhdGVuXC9Lb3RhIiwibGFzdExvZ2luQXQiOnsiZXhwcmVzc2lvbiI6IlVOSVhfVElNRVNUQU1QKCkiLCJwYXJhbXMiOltdfX0sImp0aSI6M30.BYTUR7Nt8m2D02-5-sPuU3ALqRgbWC-oU8pxCOdDenU","name":"Staff Kota Bandung","avatar":"/static/img/user.91347baa.png","introduction":"","roles":["staffKabkota"],"roles_active":{"id":"staffKabkota","label":"Staf Kabupaten/Kota"},"kel_id":null,"kec_id":null,"kabkota_id":22,"kabkota":"KOTA BANDUNG","kecamatan":null,"kelurahan":null,"dummy_image":"/static/img/user.91347baa.png"}
          }
        }
      }
    });

    wrapper.vm.submitSearch()
    wrapper.vm.resetFilter()
    wrapper.vm.changeKabkota(1)
    wrapper.vm.changeKecamatan(22)
    wrapper.vm.changeKelurahan(333)

    expect(wrapper.props("listQuery")).toBe(listQuery);
    expect(wrapper.emitted()['submit-search']).toBeTruthy()
    expect(wrapper.emitted()['reset-search']).toBeTruthy()
    expect(wrapper.vm.listQuery.kabkota_id).toBe(1)
    expect(wrapper.vm.listQuery.kec_id).toBe(22)
    expect(wrapper.vm.listQuery.kel_id).toBe(333)
  });

  // TODO: test computed of filterAreaParentId. Below code is works, but got warning. Problem between code or package version
  /* it("call computed", () => {
    const listQuery = {
      title: null,
      sort_by: "updated_at",
      sort_order: "descending",
      page: 1,
      limit: 10,
      status: null,
      kabkota_id: null,
      kec_id: null,
      kel_id: null
    }
    
    const wrapper = shallow(ListFilter, {
      localVue,
      propsData: {
        listQuery
      },
      computed: {
        filterAreaParentId: () => true
      },
      mocks: {
        $store: {
          state: {
            user: {"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NjM0NjU4NzksImlzcyI6Imh0dHA6XC9cLzM1LjI0Ny4xMzUuOTMueGlwLmlvOjgxIiwiYXVkIjoiaHR0cDpcL1wvMzUuMjQ3LjEzNS45My54aXAuaW86ODEiLCJuYmYiOjE1NjM0NjU4NzksImV4cCI6MTU2MzU1MjI3OSwiZGF0YSI6eyJ1c2VybmFtZSI6InN0YWZma2Fia290YSIsInJvbGVMYWJlbCI6IlN0YWYgS2FidXBhdGVuXC9Lb3RhIiwibGFzdExvZ2luQXQiOnsiZXhwcmVzc2lvbiI6IlVOSVhfVElNRVNUQU1QKCkiLCJwYXJhbXMiOltdfX0sImp0aSI6M30.BYTUR7Nt8m2D02-5-sPuU3ALqRgbWC-oU8pxCOdDenU","name":"Staff Kota Bandung","avatar":"/static/img/user.91347baa.png","introduction":"","roles":["staffKabkota"],"roles_active":{"id":"staffKabkota","label":"Staf Kabupaten/Kota"},"kel_id":null,"kec_id":null,"kabkota_id":22,"kabkota":"KOTA BANDUNG","kecamatan":null,"kelurahan":null,"dummy_image":"/static/img/user.91347baa.png"}
          }
        }
      }
    });

    expect(wrapper.vm.filterAreaParentId).toBeTruthy()
  }); */
});
