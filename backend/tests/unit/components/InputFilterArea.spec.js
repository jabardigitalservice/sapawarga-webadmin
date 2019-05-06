import { shallowMount, mount, createLocalVue } from '@vue/test-utils'
import ElementUI from 'element-ui'
import InputFilterArea from '@/components/InputFilterArea'

const localVue = createLocalVue()
localVue.use(ElementUI)

describe('List Filter', () => {
  const build = () => {
    const options = { localVue }
    const wrapper = shallowMount(InputFilterArea, options)
    const wrapperMounted = mount(InputFilterArea, {
      ...options, stubs: {
        transition: false
      }
    })

    return {
      wrapper,
      wrapperMounted,
      select: () => wrapper.findAll('.el-option').at(0),
      //inputMounted: () => wrapperMounted.find('.kabkota_selected'),
      // button: () => wrapperMounted.find('.btn-search'),
      // wrapper.findAll('el-option').at(0).trigger('click')
    }
  }

  it('renders the component', () => {
    // arrange
    const { wrapper } = build()

    // assert
    expect(wrapper.html()).toMatchSnapshot()
  })
})
