import { shallowMount, createLocalVue, mount } from '@vue/test-utils'
import ElementUI from 'element-ui'
import NewsList from '@/views/news/list'

const localVue = createLocalVue()
localVue.use(ElementUI)

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
    // expect(wrapper.findAll('table > tbody > tr')).toHaveLength(tableDataStatistik.length)
    // '#app > div > div.main-container > section > div > div > div > div > div.el-card__body > div > div.el-table__body-wrapper.is-scrolling-none > table > tbody > tr
    expect(wrapper.vm.tableDataStatistik).toBe(channel)
  })

  /* it('it contains the ButtonClick component', () => {
    expect(wrapper.html()).toContain('<h3>welcome to button count application</h3>')
  }) */
})
