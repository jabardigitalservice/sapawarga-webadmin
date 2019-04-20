import { shallowMount, mount } from '@vue/test-utils'
import PanelGroup from '@/views/user/components/PanelGroup'
import totalUser from '../fixtures/totalUser'

describe('PanelGroup User', () => {
  let props

  const build = () => {
    const wrapper = mount(PanelGroup, {
      propsData: props
    })
    return {
      wrapper,
      cardColumn: () => wrapper.find('.card-panel-col'),
      cardIcon: () => wrapper.find('.card-panel-icon-wrapper.icon-people'),
      cardNumber: () => wrapper.find('.card-panel-description')
    }
  }

  beforeEach(() => {
    props = {
      totalUserSummary: totalUser,
      totalAllUser: totalUser.totalUser
    }
  })

  it('renders the component', () => {
    // arrange
    const { wrapper } = build()

    // assert
    expect(wrapper.html()).toMatchSnapshot()
  })

  it('renders main elements', () => {
    // arrange
    const { cardColumn, cardIcon, cardNumber, wrapper } = build()

    // assert
    expect(cardColumn().exists()).toBe(true)
    expect(cardIcon().exists()).toBe(true)
    expect(cardNumber().exists()).toBe(true)
    // expect(cardNumber().text()).toContain('357968')
    // expect(wrapper.props('totalUserSummary').exists()).toBe(true)
    expect(wrapper.props().totalAllUser).toBe(357968)
    // expect(name().text()).toBe(props.user.name)
  })
})
