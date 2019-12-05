import { shallowMount, shallow, createLocalVue } from '@vue/test-utils'
import Router from 'vue-router'
import QuestionsAnswer from '@/views/questionsAnswer/index'
import Message from '@/views/questionsAnswer/message'

//Components
import FilterQuestions from '@/views/questionsAnswer/components/filterQuestions.vue'

const router = new Router()
const localVue = createLocalVue()
localVue.use(Router)

describe('Questions And Answer', () => {
  it('render Questions Answer', async() => {
    const listQuery = {
      name: null,
    }
    const wrapper = shallowMount(QuestionsAnswer, {
      localVue,
      propsData: {
        listQuery
      }
    })

    expect(wrapper.contains(QuestionsAnswer)).toBe(true)
  })
  it('render Message', async() => {
    const wrapper = shallowMount(Message, {
      localVue,
      router
    })

    expect(wrapper.contains(Message)).toBe(true)
  })

})
