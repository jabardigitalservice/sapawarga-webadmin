import { shallowMount, createLocalVue } from '@vue/test-utils'
import DashboardUsulan from '@/views/dashboard/admin/components/Usulan'
import DashboardApproval from '@/views/dashboard/admin/components/Approval'
import ListFilter from '@/views/dashboard/admin/components/_listfilter'
import * as apiDashboard from '@/api/dashboard'
import aspirasiMostLikesFixture from './fixtures/aspirasiMostLikes'
import ElementUI from 'element-ui'
import flushPromises from 'flush-promises'
import Vuex from 'vuex'
import DashboardMap from '@/views/dashboard/admin/components/MapData'

const localVue = createLocalVue()
localVue.use(ElementUI)
localVue.use(Vuex)

beforeEach(() => {
  jest.resetModules()
  jest.clearAllMocks()
})

jest.mock('@/api/dashboard')
apiDashboard.fetchAspirasiMostLikes = () => Promise.resolve(aspirasiMostLikesFixture)

describe('List dashboard usulan', () => {
  const expectedList = aspirasiMostLikesFixture.data.items
  it('render list usulan', async() => {
    const wrapper = shallowMount(DashboardUsulan, {
      localVue
    })

    await flushPromises()

    // ini ga perlu. Dikarenakan ketika mount sudah dipanggil di "create"
    // wrapper.vm.getList()

    expect(wrapper.vm.list).toBe(expectedList)
    expect(wrapper.contains(ListFilter)).toBe(true)

    wrapper.vm.resetFilter()
    expect(wrapper.vm.list).toBe(expectedList)
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

    const stateSidebar =
      {
        opened: true
      }

    const wrapper = shallowMount(DashboardMap, {
      localVue,
      computed: {
        sidebar: () => true
      },
      stubs: {
        fetchAspirasiMap: true
      }
    })

    wrapper.setData({ list: dataList })
    expect(wrapper.vm.list).toBe(dataList)
    expect(wrapper.vm.sidebar).toBe(stateSidebar.opened)
  })
})
