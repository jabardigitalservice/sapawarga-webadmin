import { shallowMount, createLocalVue } from '@vue/test-utils'
import Router from 'vue-router'
import ElementUI from 'element-ui'
import flushPromises from 'flush-promises'
import * as api from '@/api/popupInformasi'
import ListFilter from '@/views/popupInformasi/_listfilter'
import popupListFixture from './fixtures/popupList'
import PopupList from '@/views/popupInformasi/list'
import PopupDetail from '@/views/popupInformasi/detail'
import PopupCreate from '@/views/popupInformasi/create'
import PopupEdit from '@/views/popupInformasi/edit'


const router = new Router()
const localVue = createLocalVue()
localVue.use(Router)
localVue.use(ElementUI)


beforeEach(() => {
	jest.resetModules()
	jest.clearAllMocks()
})

jest.mock('@/api/popupInformasi')
api.fetchList = () => Promise.resolve(popupListFixture)

const listQuery = {
	type: null,
	title: null,
	status: null
}

const isEdit = false

describe('Popup', () => {
	const expectedPopupList = popupListFixture.data.items
	it('list popup', async() => {
		const status = {
			'10': 'success',
			'0': 'info',
			'-1': 'danger',
			'5': 'warning'
		}
		const wrapper = shallowMount(PopupList, {
			localVue,
			mocks: {
				$t: () => {}
			},
			propsData: {
				listQuery
			}
		})

		await flushPromises()

		expect(wrapper.contains(PopupList)).toBe(true)
		wrapper.vm.resetFilter()
		wrapper.vm.getTableRowNumbering()
		wrapper.vm.changeSort('title')
		expect(wrapper.vm.list).toBe(expectedPopupList)
	})

	it('filter', () => {
		const wrapper = shallowMount(ListFilter, {
			localVue,
			mocks: {
				$t: () => {}
			},
			propsData: {
				listQuery
			}
		})

		wrapper.vm.submitSearch()
		wrapper.vm.resetFilter()

		expect(wrapper.props('listQuery')).toBe(listQuery)
    	expect(wrapper.emitted()['submit-search']).toBeTruthy()
    	expect(wrapper.emitted()['reset-search']).toBeTruthy()
	})

	it('detail', () => {
		const wrapper = shallowMount(PopupDetail, {
			localVue,
			router,
			mocks: {
				$t: () => {}
			}
		})
		wrapper.vm.getDetail()
		expect(wrapper.contains(PopupDetail)).toBe(true)
	})

	it('create', () => {
		const wrapper = shallowMount(PopupCreate, {
			localVue,
			router,
			mocks: {
				$t: () => {}
			},
			propsData: {
				isEdit
			}
		})
		
		expect(wrapper.contains(PopupCreate)).toBe(true)
	})
})
