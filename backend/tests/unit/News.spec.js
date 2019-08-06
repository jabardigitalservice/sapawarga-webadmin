import { shallowMount, createLocalVue, mount } from '@vue/test-utils'
import ElementUI from 'element-ui'
import NewsList from '@/views/news/list'
import NewsDetail from '@/views/news/detail'
import newsDetailFixture from "./fixtures/newsDetail"
import VueRouter from 'vue-router'
import newsApi from '@/api/news'
import flushPromises from "flush-promises"
import moment from 'moment'

const localVue = createLocalVue()
localVue.use(ElementUI)
localVue.use(VueRouter)

beforeEach(() => {
  // Clear all instances and calls to constructor and all methods:
  jest.resetModules();
  jest.clearAllMocks();
});

describe('News List', () => {
  it('renders channel statistic', () => {
    const channel = [
      { title: 'humas jabar', content: 50 },
      { title: 'kompas', content: 20 },
      { title: 'Tempo', content: 10 }
    ]

    const wrapper = shallowMount(NewsList, {
      localVue,
      stubs: {
        fetchList: true
      }
    })
    wrapper.setData({ tableDataStatistik: channel })

    expect(wrapper.html()).toContain('<span>Kanal Media</span>')
    expect(wrapper.vm.tableDataStatistik).toBe(channel)
  })

})

describe('News detail', () => {
  it('show news detail', async () => {
    const router = new VueRouter()
    newsApi.fetchRecord = jest.fn(() => Promise.resolve(newsDetailFixture))
    const expDataNews =  [
      {
        title: 'Judul Berita',
        content: newsDetailFixture.data.title
      },
      {
        title: 'Sumber',
        content: newsDetailFixture.data.channel.name
      },
      {
        title: 'Target Area Video',
        content: newsDetailFixture.data.kabkota.name
      },
      {
        title: 'Tanggal Berita',
        content: '10 July 2019'
      },
      {
        title: 'Status',
        content: newsDetailFixture.data.status_label
      },
      {
        title: 'Prioritas Berita',
        content: 'Halaman Utama'
      },
      {
        title: 'URL Berita',
        content: newsDetailFixture.data.source_url
      },
      {
        title: 'Konten Berita',
        content: 'Ini berita terbaru bulan juni'
      },
      {
        title: 'Jumlah Pengunjung',
        content: newsDetailFixture.data.total_viewers + ' Pengunjung'
      }
    ]

    const wrapper = await shallowMount(NewsDetail, {
      localVue,
      router
    })
    await flushPromises();

    expect(wrapper.vm.news).toEqual(newsDetailFixture.data)
    expect(wrapper.vm.tableDataNews).toEqual(expDataNews)
    expect(wrapper.vm.validUrl(newsDetailFixture.data.source_url)).toBe(true)
  })

  it('show empty news detail', async () => {
    const router = new VueRouter()
    newsDetailFixture.data.title = null
    newsDetailFixture.data.channel = null
    newsDetailFixture.data.kabkota = null
    newsDetailFixture.data.source_date = null
    newsDetailFixture.data.status_label = null
    newsDetailFixture.data.featured = null
    newsDetailFixture.data.source_url = null
    newsDetailFixture.data.content = null
    newsDetailFixture.data.total_viewers = null
    newsApi.fetchRecord = jest.fn(() => Promise.resolve(newsDetailFixture))
    const expDataNews =  [
      {
        title: 'Judul Berita',
        content: 'Error'
      },
      {
        title: 'Sumber',
        content: 'Error'
      },
      {
        title: 'Target Area Video',
        content: 'Error'
      },
      {
        title: 'Tanggal Berita',
        content: 'Error'
      },
      {
        title: 'Status',
        content: '-'
      },
      {
        title: 'Prioritas Berita',
        content: 'List'
      },
      {
        title: 'URL Berita',
        content: 'Error'
      },
      {
        title: 'Konten Berita',
        content: 'Error'
      },
      {
        title: 'Jumlah Pengunjung',
        content: '-'
      }
    ]

    const wrapper = await shallowMount(NewsDetail, {
      localVue,
      router
    })
    await flushPromises();

    expect(wrapper.vm.news).toEqual(newsDetailFixture.data)
    expect(wrapper.vm.tableDataNews).toEqual(expDataNews)
  })
})
