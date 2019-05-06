import { shallowMount, createLocalVue } from "@vue/test-utils"
import PhotoBox from "@/components/PhotoBox"
import ElementUI from "element-ui";
const sampleImage = require("@/assets/user.png")

const localVue = createLocalVue()
localVue.use(ElementUI)

const factory = (values = {}) => {
  return shallowMount(PhotoBox, {
    // data: { ...values },
    propsData: { ...values },
    localVue
  })
}

describe('PhotoBox', () => {
  it('renders an image', () => {
    const wrapper = factory({ image: sampleImage })

    expect(wrapper.find('img').exists()).toBeTruthy()
    expect(wrapper.find('img').attributes('src')).toBe(sampleImage)

    // make sure default value for height is set
    expect(wrapper.find('.box-card-header').attributes('style')).toEqual('height: 220px;')
  })

  it('renders with custom height', () => {
    const expectedHeight = '500px;'
    const wrapper = factory({ image: sampleImage, height: '500px' })

    expect(wrapper.find('.box-card-header').attributes('style')).toBe('height: ' + expectedHeight)
  })
})
