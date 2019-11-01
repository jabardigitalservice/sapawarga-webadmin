import { shallow, shallowMount, createLocalVue } from '@vue/test-utils'
import ElementUI from 'element-ui'
import VueRouter from 'vue-router'
import login from '@/views/login/index'

const localVue = createLocalVue()
localVue.use(ElementUI)
localVue.use(VueRouter)
const router = new VueRouter()

beforeEach(() => {
  jest.resetModules()
  jest.clearAllMocks()
})

describe('login', () => {
  const build = () => {
    const wrapper = shallowMount(login, {
      localVue,
      router,
      stubs: ["svg-icon", "nuxt-link"]
    })
    return {
      wrapper
    }
  }

  it('input fields should be filled correctly', () => {
    const { wrapper } = build()
  })
})
