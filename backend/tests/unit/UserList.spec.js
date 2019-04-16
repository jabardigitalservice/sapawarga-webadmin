import { shallowMount } from '@vue/test-utils'
import UserList from '@/views/user/list'

describe('UserList', () => {
  const build = () => {
    // arrange
    const wrapper = shallowMount(UserList)
    return {
      wrapper
    }
  }

  it('renders the component', () => {
    const { wrapper } = build()
    // assert
    expect(wrapper.html()).toMatchSnapshot()
  })
})
