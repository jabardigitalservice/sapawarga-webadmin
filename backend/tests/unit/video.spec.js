import Router from 'vue-router'
import ElementUI from 'element-ui'
import flushPromises from 'flush-promises'
import * as api from '@/api/video'
import ListFilter from '@/views/video/_listfilter'
import VideoList from '@/views/video/list'
import VideoEdit from '@/views/video/edit'
import VideoDetail from '@/views/video/detail'
import VideoCreate from '@/views/video/create'
import { shallowMount, createLocalVue } from '@vue/test-utils'
import videoListFixture from './fixtures/videoList'

const localVue = createLocalVue()
const router = new Router()

localVue.use(ElementUI)
localVue.use(Router)

beforeEach(() => {
	jest.resetModules()
	jest.clearAllMocks()
})

jest.mock('@/api/video')
api.fetchList = () => Promise.resolve(videoListFixture)

const listQuery = {
	search: null,
	title: null,
	category_id: null
}

describe('Video', () => {
	const expectedVideoList = videoListFixture.data.items
	it('list video', async() => {
		const wrapper = shallowMount(VideoList, {
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
		wrapper.vm.changeSort('title')
		wrapper.vm.getTableRowNumbering()
		wrapper.vm.getStatistic()
		wrapper.vm.deleteVideo()
		wrapper.vm.deactivateRecord(20) 
		wrapper.vm.activateRecord(20)
		wrapper.vm.text_truncate('str')

		expect(wrapper.contains(VideoList)).toBe(true)
		expect(wrapper.vm.list).toBe(expectedVideoList)
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
		const wrapper = shallowMount(VideoDetail, {
			localVue,
			router,
			mocks: {
				$t: () => {}
			}
		})

		wrapper.vm.getDetail()
		wrapper.vm.record
		expect(wrapper.contains(VideoDetail)).toBe(true)
	})

	it('create', () => {
		const isEdit = false
		const wrapper = shallowMount(VideoCreate, {
			localVue,
			router,
			mocks: {
				$t: () => {}
			},
			propsData: {
				isEdit
			}
		})
		expect(wrapper.contains(VideoCreate)).toBe(true)
	})
})
