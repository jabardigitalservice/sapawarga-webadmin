import { shallowMount, createLocalVue } from '@vue/test-utils'
import ElementUI from 'element-ui'
import UserList from '@/views/user/list'

const localVue = createLocalVue()
localVue.use(ElementUI)

describe('UserList', () => {
  const build = () => {
    // arrange
    const wrapper = shallowMount(UserList, { localVue })
    return {
      wrapper
    }
  }

  it('renders the component', () => {
    const { wrapper } = build()
    // assert
    // expect(wrapper.html()).toMatchSnapshot()
  })
})
