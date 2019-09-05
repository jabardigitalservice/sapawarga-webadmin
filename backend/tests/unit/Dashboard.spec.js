import { shallowMount, createLocalVue } from '@vue/test-utils'
import DashboardUsulan from '@/views/dashboard/admin/components/Usulan'
import DashboardApproval from '@/views/dashboard/admin/components/Approval'
import ListFilter from '@/views/dashboard/admin/components/_listfilter'
import ElementUI from 'element-ui'
import Vuex from 'vuex'
import usulanGeoFixture from './fixtures/usulanGeo'
import { fetchAspirasiMap } from '@/api/dashboard'

const localVue = createLocalVue()
localVue.use(ElementUI)
localVue.use(Vuex)

beforeEach(() => {
  jest.resetModules()
  jest.clearAllMocks()
})

describe('List dashboard usulan', () => {
  it('render list usulan', () => {
    const wrapper = shallowMount(DashboardUsulan, {
      localVue
    })

    wrapper.vm.getList()
    wrapper.vm.resetFilter()

    expect(wrapper.contains(ListFilter)).toBe(true)
  })

  it('render _listfilter', () => {
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

    expect(wrapper.props('listQuery')).toBe(listQuery)
    expect(wrapper.emitted()['submit-search']).toBeTruthy()
    expect(wrapper.emitted()['reset-search']).toBeTruthy()
  })

  it('render dashboard approval', () => {
    const wrapper = shallowMount(DashboardApproval, {
      localVue
    })

    expect(wrapper.is(DashboardApproval)).toBe(true)
  })

  // it('get list usulan geo', () => {
  //   const dataList = [
  //     {
  //       name: 'KOTA BANDUNG',
  //       counts: '16',
  //       kabkota_id: '22',
  //       latitude: '107.590417459601',
  //       longitude: '-6.95981961897412'
  //     }
  //   ]
  //   const wrapper = shallowMount(DashboardMap, {
  //     localVue,
  //     stubs: {
  //       fetchAspirasiMap: true
  //     }
  //   })

  //   // const wrapper = shallowMount(getters, {
  //   //   localVue
  //   // })

  //   wrapper.setData({ list: dataList })
  //   // expect(wrapper.find('.map-getters').text().trim()).toBe('value_1')
  //   expect(wrapper.vm.list).toBe(dataList)
  // })

  // it('render siderbar fro getters', () => {
  //   const wrapper = shallowMount(DashboardMap, {
  //     mocks: {
  //       $store: {
  //         getters: {
  //           sidebar: {opened: true}
  //         }
  //       }
  //     }
  //   })

  //   expect(wrapper.is('opened')).toBe(true)
  // // })
  // it('renders getters', () => {
  //   const wrapper = shallow(getters, {
  //     localVue,
  //     computed: {
  //       sidebar: () => 'value'
  //     }
  //   })
  //   expect(wrapper.find('.map-getters').text()).toEqual('value')
  // })
})
