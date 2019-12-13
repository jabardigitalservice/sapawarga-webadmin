import { shallowMount, createLocalVue } from '@vue/test-utils'
import ElementUI from 'element-ui'
import DetailData from '@/components/DetailData/index.vue'

const localVue = createLocalVue()
localVue.use(ElementUI)

describe('DetailData.vue', () => {
  it('should receive and render props correctly', () => {
    const wrapper = shallowMount(DetailData, {
      localVue,
      propsData: {
        tableContentData: [{
            title: 'Judul Berita',
            content: 'Isi Judul Berita'
        }]
      },
      computed: {
        device: () => 'desktop'
      }
    })
    expect(wrapper.props('tableContentData')).toEqual([{
        title: 'Judul Berita',
        content: 'Isi Judul Berita'
    }])
    expect(wrapper.html()).toContain('<span>Isi Judul Berita</span>')
  })
})
