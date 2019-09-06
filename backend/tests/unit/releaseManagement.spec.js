import { shallowMount, createLocalVue } from '@vue/test-utils'
import ElementUI from 'element-ui';
import releaseManagementCreate from '@/views/releaseManagement/create'
import releaseManagementList from '@/views/releaseManagement/list'
import Form from '@/views/releaseManagement/components/Form'

const localVue = createLocalVue()
localVue.use(ElementUI)

beforeEach(() => {
  // Clear all instances and calls to constructor and all methods:
  jest.resetModules()
  jest.clearAllMocks()
})

describe('Categories', () => {
  it('call create form', () => {
    const wrapper = shallowMount(releaseManagementCreate, {
      localVue
    })

    expect(wrapper.find(Form).exists()).toBe(true)
  })
  it('call list release management', () => {
    const wrapper = shallowMount(releaseManagementList, {
      localVue
    })

    expect(wrapper.find(releaseManagementList).exists()).toBe(true)
  })
})
