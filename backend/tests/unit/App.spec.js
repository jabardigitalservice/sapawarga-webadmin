import { mount, createLocalVue } from '@vue/test-utils'
import Router from 'vue-router'
import App from '@/App'

const localVue = createLocalVue()
localVue.use(Router)

const router = new Router()

describe('App.vue', () => {
  const wrapper = mount(App, {
    localVue,
    router
  })

  it('is a Vue instance', () => {
    expect(wrapper.isVueInstance()).toBeTruthy()
  })
})
