import Router from 'vue-router'
import ElementUI from 'element-ui'
import flushPromises from 'flush-promises'
import * as api from '@/api/newsImportant'
import ListFilter from '@/views/newsImportant/_listfilter'
import newsImportantList from '@/views/newsImportant/list'
import NewsImportantEdit from '@/views/newsImportant/edit'
import NewsImportantDetail from '@/views/newsImportant/detail'
import NewsImportantCreate from '@/views/newsImportant/create'
import { shallowMount, createLocalVue } from '@vue/test-utils'
import newsImportantListFixture from './fixtures/newsImportantList'

const localVue = createLocalVue()
const router = new Router()

localVue.use(ElementUI)
localVue.use(Router)

beforeEach(() => {
	jest.resetModules()
	jest.clearAllMocks()
})

jest.mock('@/api/newsImportant')
api.fetchList = () => Promise.resolve(newsImportantListFixture)

const listQuery = {
	search: null,
  category_id: null,
  status: null
}

describe('NewsImportant', () => {
	const expectedNewsImportantList = newsImportantListFixture.data.items
	it('list newsImportant', async() => {
		const wrapper = shallowMount(newsImportantList, {
			localVue,
			mocks: {
				$t: () => {}
			},
			propsData: {
				listQuery
			}
		})

		await flushPromises()

		wrapper.vm.resetFilter()
		wrapper.vm.activateRecord(20)
		wrapper.vm.changeSort('title')
		wrapper.vm.deactivateRecord(20) 
		wrapper.vm.getTableRowNumbering()
		wrapper.vm.deleteNewsImportant(20) 
		
		expect(wrapper.contains(newsImportantList)).toBe(true)
		expect(wrapper.vm.list).toBe(expectedNewsImportantList)
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
		expect(wrapper.emitted()['reset-search']).toBeTruthy()
		expect(wrapper.emitted()['submit-search']).toBeTruthy()
	})

	it('detail', () => {
		const wrapper = shallowMount(NewsImportantDetail, {
			localVue,
			router,
			mocks: {
				$t: () => {}
			}
		})

		wrapper.vm.getDetail()
		wrapper.vm.tableDataRecord
		wrapper.vm.tableImageAttachment
		wrapper.vm.attachments
		expect(wrapper.contains(NewsImportantDetail)).toBe(true)
	})

	it('create', () => {
		const isEdit = false
		const wrapper = shallowMount(NewsImportantCreate, {
			localVue,
			router,
			mocks: {
				$t: () => {}
			},
			propsData: {
				isEdit
			}
		})
		expect(wrapper.contains(NewsImportantCreate)).toBe(true)
	})

	it('edit', () => {
		const isEdit = true
		const wrapper = shallowMount(NewsImportantEdit, {
			localVue,
			router,
			mocks: {
				$t: () => {}
			},
			propsData: {
				isEdit
			}
		})
		expect(wrapper.contains(NewsImportantEdit)).toBe(true)
	})
})