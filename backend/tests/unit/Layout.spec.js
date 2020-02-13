import { shallow, shallowMount, createLocalVue } from '@vue/test-utils'
import ElementUI from 'element-ui'
import VueRouter from 'vue-router'
import Layout from '@/layout'
import store from '@/store'

const localVue = createLocalVue()
localVue.use(ElementUI)
localVue.use(VueRouter)
const router = new VueRouter()

beforeEach(() => {
  jest.resetModules()
  jest.clearAllMocks()
})

describe('layout', () => {
  const build = () => {
    const wrapper = shallowMount(Layout, {
      localVue,
      router,
      store,
      mocks: {
        $t: () => {}
      }
    })
    return {
      wrapper
    }
  }

  it('input fields should be filled correctly', () => {
    const { wrapper } = build()
  })
})
