import { shallowMount, createLocalVue } from '@vue/test-utils'
import ElementUI from 'element-ui'
import BottomBar from '@/components/BottomBar/index.vue'

const localVue = createLocalVue()
localVue.use(ElementUI)

describe('BottomBar.vue', () => {
  //@todo: write proper test case for role 'gubernur' and small device 
  it('should be able to render BottomBar correctly on mobile device as governor role', () => {
    const wrapper = shallowMount(BottomBar, {
      localVue,
      computed: {
        device: () => 'mobile'
      }
    })
  })
})
