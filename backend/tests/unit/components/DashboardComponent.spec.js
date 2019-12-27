import { mount, shallowMount, createLocalVue } from '@vue/test-utils'
import * as apiDashboard from '@/api/dashboard'
import aspirationMapFixture from '../fixtures/aspirationMap'
import DashboardMap from '@/components/Dashboard/MapAspiration'
import Polling from '@/components/Dashboard/Polling'
import TopNews from '@/components/Dashboard/TopNews'
import TopQNA from '@/components/Dashboard/TopQNA'
import ElementUI from 'element-ui'
import L from 'leaflet'
import i18n from '@/lang'
import echarts from 'echarts'
const macarons = require('echarts/theme/macarons')
import resize from '@/utils/resizeChart'

beforeEach(() => {
  jest.resetModules()
  jest.clearAllMocks()
})

jest.mock('@/api/dashboard')
apiDashboard.fetchAspirasiMap = () => Promise.resolve(aspirationMapFixture)
const localVue = createLocalVue()
localVue.use(ElementUI)
localVue.use(echarts)
localVue.use(macarons)
localVue.use(resize)

describe('Dashboard', () => {
  const expectedAspirationMap = aspirationMapFixture.data

  it('render dashboard map aspiration', () => {
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
      i18n
    })

    expect(wrapper.is(Polling)).toBe(true)
  })

  it('render dashboard top news', () => {
    const wrapper = shallowMount(TopNews, {
      localVue,
      i18n
    })

    expect(wrapper.is(TopNews)).toBe(true)
  })

  it('render dashboard top qna', () => {
    const wrapper = shallowMount(TopQNA, {
      localVue,
      i18n
    })

    expect(wrapper.is(TopQNA)).toBe(true)
  })
})
