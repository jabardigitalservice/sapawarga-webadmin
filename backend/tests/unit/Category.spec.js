import { shallowMount, createLocalVue } from '@vue/test-utils'
import ElementUI from 'element-ui';
import CategoryCreate from '@/views/categories/create'
import Form from '@/views/categories/components/Form'

const localVue = createLocalVue()
localVue.use(ElementUI)

beforeEach(() => {
  // Clear all instances and calls to constructor and all methods:
  jest.resetModules()
  jest.clearAllMocks()
})

describe('Categories', () => {
  it('call create form', () => {
    const wrapper = shallowMount(CategoryCreate, {
      localVue
    })

    expect(wrapper.find(Form).exists()).toBe(true)
  })
})
