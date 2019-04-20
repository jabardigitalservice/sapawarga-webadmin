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
      cardIcon: () => wrapper.find('.card-panel-icon-wrapper.icon-people-all'),
      cardNumber: () => wrapper.find('.card-panel-description')
    }
  }

  beforeEach(() => {
    props = {
      totalUserSummary: totalUser,
      totalAllUser: totalUser.totalUser,
      duration: 1
    }
  })

  it('renders the component', () => {
    // arrange
    const { wrapper } = build()

    // assert
    expect(wrapper.html()).toMatchSnapshot()
  })

  it('renders main elements', (done) => {
    // arrange
    const { cardColumn, cardIcon, cardNumber, wrapper } = build()

    // assert
    expect(cardColumn().exists()).toBe(true)
    expect(cardIcon().exists()).toBe(true)
    expect(cardNumber().exists()).toBe(true)

    expect(cardNumber().text()).toContain('0')

    setTimeout(() => {
      expect(wrapper.text()).toContain('Semua')
      expect(wrapper.text()).toContain('99')
      done()
    }, 1100)

    expect(wrapper.props().totalAllUser).toBe(totalUser.totalUser)
    // expect(name().text()).toBe(props.user.name)
  })
})
