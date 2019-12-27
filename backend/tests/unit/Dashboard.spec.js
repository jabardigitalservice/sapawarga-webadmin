import { shallowMount, createLocalVue } from '@vue/test-utils'
import DashboardUsulan from '@/views/dashboard/admin/components/Usulan'
import DashboardApproval from '@/views/dashboard/admin/components/Approval'
import ListFilter from '@/views/dashboard/admin/components/_listfilter'
import * as apiDashboard from '@/api/dashboard'
import aspirasiMostLikesFixture from './fixtures/aspirasiMostLikes'
import CategoryaspirasiMostLikesFixture from './fixtures/categoryAspirasiMostLikes'
import pollingLatestFixture from './fixtures/pollingLatest'
import aspirationCountFixture from './fixtures/aspirationCount'
import aspirationMapFixture from './fixtures/aspirationMap'
import ElementUI from 'element-ui'
import flushPromises from 'flush-promises'
import Vuex from 'vuex'
import DashboardMap from '@/views/dashboard/admin/components/MapData'
import DashboardCategory from '@/views/dashboard/admin/components/Category'
import Polling from '@/views/dashboard/admin/components/Polling'
import DashboardLeader from '@/views/dashboard/leader'
import L from 'leaflet'
import i18n from '@/lang'

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
apiDashboard.fetchCategoryAspirasiMostLikes = () => Promise.resolve(CategoryaspirasiMostLikesFixture)

describe('List dashboard usulan', () => {
  const expectedList = aspirasiMostLikesFixture.data.items
  const expectedPollingLatest = pollingLatestFixture.data
  const expectedAspirationCount = aspirationCountFixture.data
  const expectedAspirationMap = aspirationMapFixture.data
  const expectedCategory = CategoryaspirasiMostLikesFixture.data

  it('render list usulan', async() => {
    const wrapper = shallowMount(DashboardUsulan, {
      localVue,
      mocks: {
        $t: () => {}
      },
      i18n
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
      i18n,
      propsData: {
        listQuery
      }
    })

    wrapper.vm.submitSearch()
    wrapper.vm.resetFilter()
    wrapper.vm.getArea()
    wrapper.vm.setWidth()

    expect(wrapper.props('listQuery')).toBe(listQuery)
    expect(wrapper.emitted()['submit-search']).toBeTruthy()
    expect(wrapper.emitted()['reset-search']).toBeTruthy()
    expect(wrapper.vm.roles).toEqual(user)
    expect(wrapper.vm.setWidth)
    expect(wrapper.vm.getArea)
  })

  it('render dashboard approval', async() => {

    const wrapper = shallowMount(DashboardApproval, {
      localVue,
      mocks: {
        $t: () => {}
      },
      i18n
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
    const kabkota =
      {
        id: 22
      }

    const wrapper = shallowMount(DashboardMap, {
      localVue,
      L,
      i18n,
      computed: {
        sidebar: () => true,
        user: () => 22
      },
      stubs: {
        fetchAspirasiMap: true
      }
    })

    wrapper.setData({ list: dataList })
    expect(wrapper.vm.list).toBe(dataList)
    expect(wrapper.vm.sidebar).toBe(stateSidebar.opened)
    expect(wrapper.vm.user).toBe(kabkota.id)
  })


  it('render dashboard polling', () => {
    const wrapper = shallowMount(Polling, {
      localVue,
      mocks: {
        $t: () => {}
      },
      i18n
    })

    expect(wrapper.is(Polling)).toBe(true)
  })

  it('function list polling latest', async() => {
    const wrapper = shallowMount(Polling, {
      localVue,
      mocks: {
        $t: () => {}
      },
      i18n
    })

    await flushPromises()
    expect(wrapper.vm.list).toBe(expectedPollingLatest)
  })

  it('function displayChart dashboard polling', () => {
    const wrapper = shallowMount(Polling, {
      localVue,
      mocks: {
        $t: () => {}
      },
      i18n
    })

    const id = 123
    const data = {
      id: 1
    }
    wrapper.vm.displayChart(data)
    expect(wrapper.vm.id).toBe(data.id)
  })

  it('Category', () => {
    const category = [{
				'name':'Infrastruktur',
				'total':333
      }]
    const wrapper = shallowMount(DashboardCategory, {
      localVue,
      mocks: {
        $t: () => {}
      },
      i18n
    })

    wrapper.vm.getTableRowNumbering()
    wrapper.setData({ list: category })
    expect(wrapper.vm.list).toBe(category)

  })

  it('render dashboard leader', () => {
    const wrapper = shallowMount(DashboardLeader, {
      localVue,
      i18n
    })

    expect(wrapper.is(DashboardLeader)).toBe(true)
  })

})
