import { shallow, shallowMount, createLocalVue } from '@vue/test-utils'
import ElementUI from 'element-ui'
import VueRouter from 'vue-router'
import verifikasiUser from '@/views/verifikasiUser/index'

const localVue = createLocalVue()
localVue.use(ElementUI)
localVue.use(VueRouter)
const router = new VueRouter()

beforeEach(() => {
  jest.resetModules()
  jest.clearAllMocks()
})

describe('verifikasiUser', () => {
  const build = () => {
    const wrapper = shallowMount(verifikasiUser, {
      localVue,
      router
    })
    return {
      wrapper
    }
  }

  it('input fields should be filled correctly', () => {
    const { wrapper } = build()
  })
})
