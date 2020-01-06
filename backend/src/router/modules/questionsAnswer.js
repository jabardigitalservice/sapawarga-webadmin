import Layout from '@/layout'

const questionsAnswerRouter = {
  name: 'question-answer-manage',
  path: '/question-answer',
  component: Layout,
  redirect: '/question-answer/index',
  meta: {
    title: 'question-answer-manage',
    roles: ['admin', 'staffProv', 'pimpinan'],
    icon: 'icon-qna'
  },
  children: [
    {
      name: 'question-answer-manage',
      path: 'index',
      component: () => import('@/views/questionsAnswer/index'),
      hidden: true,
      meta: {
        title: 'question-answer-list',
        roles: ['admin', 'staffProv', 'pimpinan']
      }
    },
    {
      name: 'question-answer',
      path: 'messages/:id',
      component: () => import('@/views/questionsAnswer/message'),
      hidden: true,
      meta: {
        title: 'question-answer-message',
        roles: ['admin', 'staffProv', 'pimpinan']
      }
    }
  ]
}

export default questionsAnswerRouter
