import { shallow, shallowMount, createLocalVue } from '@vue/test-utils'
import ElementUI from 'element-ui'
import VueRouter from 'vue-router'
import FormResetPassword from '@/views/resetPassword/index'

const localVue = createLocalVue()
localVue.use(ElementUI)
localVue.use(VueRouter)
const router = new VueRouter()

beforeEach(() => {
  jest.resetModules()
  jest.clearAllMocks()
})

describe('FormResetPassword', () => {
  const build = () => {
    const wrapper = shallowMount(FormResetPassword, {
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
