import { shallowMount, createLocalVue } from '@vue/test-utils'
import MapThumb from '@/components/MapThumb'
import ElementUI from 'element-ui';

const localVue = createLocalVue()
localVue.use(ElementUI)

const factory = (values = {}) => {
  return shallowMount(MapThumb, {
    propsData: { ...values },
    localVue
  })
}

describe('MapThumb', () => {
  it('renders a map', () => {
    const latitude = '-6.7'
    const longitude = '107.1'
    const urlMap = `https://maps.google.com/maps?q=${latitude},${longitude}&t=&z=16&ie=UTF8&iwloc=&output=embed`
    const wrapper = factory({ latitude, longitude })

    expect(wrapper.find('iframe').exists()).toBeTruthy()
    expect(wrapper.find('iframe').attributes('src')).toBe(urlMap)
    expect(wrapper.find('iframe').attributes('id')).toBe('gmap_canvas')
  })
})
