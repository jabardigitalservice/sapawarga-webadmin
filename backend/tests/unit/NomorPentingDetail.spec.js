// jest.mock('@/api/phonebooks')
import { shallowMount, createLocalVue } from "@vue/test-utils"
import Show from '@/views/nomorPenting/show'
import PhotoBox from "@/components/PhotoBox"
import ElementUI from "element-ui";
const sampleImage = require("@/assets/user.png")
import Router from 'vue-router'
// import { fetchDetail } from '@/api/phonebooks'

const localVue = createLocalVue()
localVue.use(ElementUI, Router)
const router = new Router({ name: 'nomor-penting-show', params: { id: 578 } })

let $route = {
  // http://localhost:9527/backend/#/nomor-penting/show/140
  path: '/nomor-penting/show/578',
  params: { id: 578 },
}

const factory = (values = {}) => {
  return shallowMount(Show, {
    // data: { ...values },
    propsData: { ...values },
    localVue,
    /* mocks: {
      $route
    }, */
    stubs: ['vue-friendly-iframe'],
    router
  })
}

describe('Nomor Penting Show Detail', () => {
  it('renders main component', () => {
    const wrapper = factory()

    expect(wrapper.html()).toMatchSnapshot()
    expect(wrapper.props().id).not.toBe(0)

  })

  it('renders main child components', () => {
    const wrapper = factory()

    expect(wrapper.find(PhotoBox).exists()).toBe(true)
  })
})
