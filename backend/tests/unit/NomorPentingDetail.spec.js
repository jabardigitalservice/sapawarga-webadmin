import { shallowMount, createLocalVue } from "@vue/test-utils"
import Show from '@/views/nomorPenting/show'
// import PhotoBox from "@/components/PhotoBox"
import ElementUI from "element-ui";
const sampleImage = require("@/assets/user.png")

const localVue = createLocalVue()
localVue.use(ElementUI)

const $route = {
  // http://localhost:9527/backend/#/nomor-penting/show/140
  path: '/nomor-penting/show/140',
  params: { id: '578' },
}

const factory = (values = {}) => {
  return shallowMount(Show, {
    // data: { ...values },
    propsData: { ...values },
    localVue,
    mocks: {
      $route
    }
  })
}

describe('Nomor Penting Show Detail', () => {
  it('renders main component', () => {
    const wrapper = factory()

    expect(wrapper.html()).toMatchSnapshot()
  })
})
