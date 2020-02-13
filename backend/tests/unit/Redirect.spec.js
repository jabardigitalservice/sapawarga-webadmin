import { shallowMount, createLocalVue } from '@vue/test-utils'
import ElementUI from 'element-ui'
import Router from 'vue-router'
import Vue from 'vue'

import Redirect from '@/views/redirect'
const router = new Router()
const localVue = createLocalVue()
localVue.use(ElementUI)
localVue.use(Router)

describe('Redirect.vue', () => {
  it('should render redirect', () => {
    shallowMount(Redirect, {
      localVue,
      router
    })
  })
})
