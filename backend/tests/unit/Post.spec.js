import { shallowMount, shallow, createLocalVue } from '@vue/test-utils'
import Router from 'vue-router'
import ElementUI from 'element-ui'
import PostList from '@/views/post/list'
import flushPromises from 'flush-promises'
import * as api from '@/api/post'
import ListFilter from '@/views/post/_listfilter'
import PostDetail from '@/views/post/detail'
import postListFixture from './fixtures/postList'

const router = new Router()
const localVue = createLocalVue()
localVue.use(Router)
localVue.use(ElementUI)

beforeEach(() => {
  jest.resetModules()
  jest.clearAllMocks()
})

jest.mock('@/api/dashboard')
api.fetchList = () => Promise.resolve(postListFixture)


describe('Post', () => {
	const expectedPostList = postListFixture.data.items
  it('render list post', async() => {
		const listQuery = {
			title: null,
			status: null
		}
		const status = {
			'10': 'success',
			'0': 'info',
			'-1': 'danger',
			'5': 'warning'
		}
		const wrapper = shallowMount(PostList, {
			localVue,
			mocks: {
        $t: () => {}
      },
			propsData: {
				listQuery
			}
		})

		await flushPromises()

		expect(wrapper.contains(PostList)).toBe(true)
		wrapper.vm.resetFilter()
		wrapper.vm.getTableRowNumbering()
		wrapper.vm.changeSort('title')
		expect(wrapper.vm.list).toBe(expectedPostList)
	})

	it('render filter', () => {
		const listQuery = {
			title: null,
			status: null
		}

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

	it('render detail', () => {
		const wrapper = shallowMount(PostDetail, {
			localVue,
      router,
			mocks: {
        $t: () => {}
			}
		})
		wrapper.vm.getDetail()
		wrapper.vm.deactivateRecord()
		wrapper.vm.activateRecord()
		expect(wrapper.contains(PostDetail)).toBe(true)
	})
})
