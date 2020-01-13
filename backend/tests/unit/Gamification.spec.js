import { shallowMount, shallow, createLocalVue } from '@vue/test-utils'
import Router from 'vue-router'
import ElementUI from 'element-ui'
import flushPromises from 'flush-promises'
import FormGamification from '@/views/gamification/components/FormGamification'
import CreateGamification from '@/views/gamification/create'
import EditGamification from '@/views/gamification/edit'
import ListGamification from '@/views/gamification/list'
import i18n from '@/lang'

const router = new Router()
const localVue = createLocalVue()
localVue.use(Router)
localVue.use(ElementUI)

beforeEach(() => {
  jest.resetModules()
  jest.clearAllMocks()
})

const listQuery = {
  params: '',
  title: null,
  status: null
}

describe('Gamification', () => {
  it('render list gamification', async() => {
		const status = {
			'10': 'success',
			'0': 'info',
			'-1': 'danger',
			'5': 'warning'
		}
		const wrapper = shallowMount(ListGamification, {
			localVue,
			i18n,
			propsData: {
				listQuery
			}
		})

		await flushPromises()

		expect(wrapper.contains(ListGamification)).toBe(true)
	})

	it('render form gamification', () => {
		const wrapper = shallowMount(FormGamification, {
			localVue,
			i18n
		})

		wrapper.vm.submitForm()

    expect(wrapper.contains(FormGamification)).toBe(true)
	})

  it('render create gamification', () => {
		const wrapper = shallowMount(CreateGamification, {
			localVue,
			i18n
		})

    expect(wrapper.contains(CreateGamification)).toBe(true)
	})

  it('render edit gamification', () => {
		const wrapper = shallowMount(EditGamification, {
			localVue,
			i18n
		})

    expect(wrapper.contains(EditGamification)).toBe(true)
	})
})
