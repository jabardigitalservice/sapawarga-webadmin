import { shallowMount, createLocalVue } from '@vue/test-utils'
import DashboardUsulan from '@/views/dashboard/admin/components/Usulan'
import DashboardMap from '@/views/dashboard/admin/components/MapData'
import DashboardApproval from '@/views/dashboard/admin/components/Approval'
import ListFilter from '@/views/dashboard/admin/components/_listfilter'
import ElementUI from 'element-ui'
import usulanGeoFixture from './fixtures/usulanGeo'
import { fetchAspirasiMap } from '@/api/dashboard'

const localVue = createLocalVue()
localVue.use(ElementUI)

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

  it('get list usulan geo', () => {
    const dataList = [
      {
        name: 'KOTA BANDUNG',
        counts: '16',
        kabkota_id: '22',
        latitude: '107.590417459601',
        longitude: '-6.95981961897412'
      }
    ]
    const wrapper = shallowMount(DashboardMap, {
      localVue,
      stubs: {
        fetchAspirasiMap: true
      }
    })

    wrapper.setData({ list: dataList })

    expect(wrapper.vm.list).toBe(dataList)
  })
})
