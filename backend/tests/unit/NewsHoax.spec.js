import { shallowMount, createLocalVue } from '@vue/test-utils'
import ElementUI from 'element-ui'
import NewsHoaxList from '@/views/newsHoax/list'
import NewsHoaxDetail from '@/views/newsHoax/detail'
import newsHoaxDetailFixture from './fixtures/newsHoaxDetail'
import VueRouter from 'vue-router'
import newsHoaxApi from '@/api/newsHoax'
import flushPromises from 'flush-promises'
import i18n from '@/lang'

const localVue = createLocalVue()
localVue.use(ElementUI)
localVue.use(VueRouter)

beforeEach(() => {
  // Clear all instances and calls to constructor and all methods:
  jest.resetModules()
  jest.clearAllMocks()
})

describe('News Hoax List', () => {
  it('renders channel statistic', () => {
    const channel = [
      { title: 'humas jabar', content: 50 },
      { title: 'kompas', content: 20 },
      { title: 'Tempo', content: 10 }
    ]

    const wrapper = shallowMount(NewsHoaxList, {
      localVue,
      stubs: {
        fetchList: true
      },
      i18n
    })
    wrapper.setData({ list: channel })
    expect(wrapper.vm.list).toBe(channel)
  })
})

describe('News Hoax detail', () => {
  it('show news detail', async() => {
    const router = new VueRouter()
    newsHoaxDetailFixture.data.title = null
    newsHoaxDetailFixture.data.category = null
    newsHoaxDetailFixture.data.source_date = null
    newsHoaxDetailFixture.data.content = null
    newsHoaxDetailFixture.data.total_viewers = null
    newsHoaxApi.fetchRecord = jest.fn(() => Promise.resolve(newsHoaxDetailFixture))
    const expDataNews = [
      {
        title: 'Judul Berita',
        content: newsHoaxDetailFixture.data.title
      },
      {
        title: 'Kategori Berita',
        content: newsHoaxDetailFixture.data.category_id
      },
      {
        title: 'Tanggal Berita',
        content: '18 July 2019'
      },
      {
        title: 'Konten Berita',
        content: newsHoaxDetailFixture.data.content
      },
      {
        title: 'Status',
        content: newsHoaxDetailFixture.data.status
      },
      {
        title: 'Jumlah Pengunjung',
        content: newsHoaxDetailFixture.data.total_viewers + ' Pengunjung'
      }
    ]

    const wrapper = await shallowMount(NewsHoaxDetail, {
      localVue,
      router,
      i18n
    })
    await flushPromises()

    // strip the content
    expDataNews[3].content = wrapper.vm.strip(newsHoaxDetailFixture.data.content)

    expect(wrapper.vm.validUrl(newsHoaxDetailFixture.data.source_url)).toBe(true)
  })
})
