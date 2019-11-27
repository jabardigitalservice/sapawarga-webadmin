import { shallowMount, createLocalVue } from '@vue/test-utils'
import DashboardUsulan from '@/views/dashboard/admin/components/Usulan'
import DashboardApproval from '@/views/dashboard/admin/components/Approval'
import ListFilter from '@/views/dashboard/admin/components/_listfilter'
import * as apiDashboard from '@/api/dashboard'
import aspirasiMostLikesFixture from './fixtures/aspirasiMostLikes'
import pollingLatestFixture from './fixtures/pollingLatest'
import aspirationCountFixture from './fixtures/aspirationCount'
import aspirationMapFixture from './fixtures/aspirationMap'
import ElementUI from 'element-ui'
import flushPromises from 'flush-promises'
import Vuex from 'vuex'
import DashboardMap from '@/views/dashboard/admin/components/MapData'
import Polling from '@/views/dashboard/admin/components/Polling'

const localVue = createLocalVue()
localVue.use(ElementUI)
localVue.use(Vuex)

beforeEach(() => {
  jest.resetModules()
  jest.clearAllMocks()
})

jest.mock('@/api/dashboard')
apiDashboard.fetchAspirasiMostLikes = () => Promise.resolve(aspirasiMostLikesFixture)
apiDashboard.fetchLatestPolling = () => Promise.resolve(pollingLatestFixture)
apiDashboard.fetchAspirasiCounts = () => Promise.resolve(aspirationCountFixture)
apiDashboard.fetchAspirasiMap = () => Promise.resolve(aspirationMapFixture)

describe('List dashboard usulan', () => {
  const expectedList = aspirasiMostLikesFixture.data.items
  const expectedPollingLatest = pollingLatestFixture.data
  const expectedAspirationCount = aspirationCountFixture.data
  const expectedAspirationMap = aspirationMapFixture.data

  it('render list usulan', async() => {
    const wrapper = shallowMount(DashboardUsulan, {
      localVue,
      mocks: {
        $t: () => {}
      }
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

    const user = ['admin']

    const wrapper = shallowMount(ListFilter, {
      localVue,
      computed: {
        roles: () => ['admin']
      },
      mocks: {
        $t: () => {}
      },
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
    expect(wrapper.vm.roles).toEqual(user)
  })

  it('render dashboard approval', async() => {

    const wrapper = shallowMount(DashboardApproval, {
      localVue,
      mocks: {
        $t: () => {}
      }
    })

    await flushPromises()

    const result = [{accept: expectedAspirationCount.STATUS_APPROVAL_PENDING, publish: expectedAspirationCount.STATUS_PUBLISHED}]
    wrapper.setData({ list: result })
    expect(wrapper.vm.list).toBe(result)
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

  it('render dashboard polling', () => {
    const wrapper = shallowMount(Polling, {
      localVue
    })

    expect(wrapper.is(Polling)).toBe(true)
  })

  it('function list polling latest', async() => {
    const wrapper = shallowMount(Polling, {
      localVue
    })

    await flushPromises()
    expect(wrapper.vm.list).toBe(expectedPollingLatest)
  })

  it('function displayChart dashboard polling', () => {
    const wrapper = shallowMount(Polling, {
      localVue
    })
    
    const id = 123
    const data = {
      id: 1
    }    
    wrapper.vm.displayChart(data)
    expect(wrapper.vm.id).toBe(data.id)
  })
})
