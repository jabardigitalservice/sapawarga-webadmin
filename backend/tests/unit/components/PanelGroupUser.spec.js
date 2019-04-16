import { shallowMount } from '@vue/test-utils'
import PanelGroup from '@/views/user/components/PanelGroup'
// import totalUser from './fixtures/totalUser'

describe('PanelGroup User', () => {
  let props

  const build = () => {
    const wrapper = shallowMount(PanelGroup, {
      propsData: props,
    })
    return {
      wrapper,
      cardColumn: () => wrapper.find('.card-panel-col'),
      cardIcon: () => wrapper.find('.card-panel-icon-wrapper'),
      cardNumber: () => wrapper.find('.card-panel-text'),
    }
  }

  beforeEach(() => {
    /* props = {
      totalUser
    } */
  })

  it('renders the component', () => {
    // arrange
    const { wrapper } = build()
    // assert
    expect(wrapper.html()).toMatchSnapshot()
  })

  /* it('renders main components', () => {
    // arrange
    const { avatar, name, bio } = build()
    // assert

    expect(name().exists()).toBe(true)
    expect(name().text()).toBe(props.user.name)
  }) */

})
