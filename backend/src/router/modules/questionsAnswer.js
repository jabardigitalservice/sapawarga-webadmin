import Layout from '@/layout'

const questionsAnswerRouter = {
  name: 'Tanya Jawab',
  path: '/question-answer',
  component: Layout,
  redirect: '/question-answer/index',
  meta: {
    title: 'question-answer-manage',
    roles: ['admin', 'staffProv'],
    icon: 'message'
  },
  children: [
    {
      name: 'question-answer-list',
      path: 'index',
      component: () => import('@/views/questionsAnswer/index'),
      meta: {
        title: 'question-answer-list',
        roles: ['admin', 'staffProv']
      }
    },
    {
      name: 'question-answer',
      path: 'messages/:id',
      component: () => import('@/views/questionsAnswer/message'),
      hidden: true,
      meta: {
        title: 'question-answer-message',
        roles: ['admin', 'staffProv']
      }
    }
  ]
}

export default questionsAnswerRouter
