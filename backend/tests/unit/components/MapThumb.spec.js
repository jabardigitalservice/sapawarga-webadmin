import { mount, createLocalVue } from '@vue/test-utils'
import MapThumb from '@/components/MapThumb'
import ElementUI from 'element-ui'
import i18n from '@/lang'
import L from 'leaflet';

const localVue = createLocalVue()
localVue.use(ElementUI)

describe('MapThumb', () => {
  it('renders a map', async() => {
    const props = {
      latitude:  '-6.8675185',
      longitude: '107.0446946',
      id: 'gmap_canvas'
    };
    const wrapper = await mount(MapThumb, {
      propsData: props,
      localVue,
      i18n,
      Map
    })
    expect(wrapper.html()).toContain('<div id="leafletmap"></div>')
  })
})
