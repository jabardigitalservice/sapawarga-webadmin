import Layout from '@/layout'

const questionsAnswerRouter = {
  name: 'Pertanyaan Jawaban',
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
      component: () => import('@/views/questionsAnswer/messageBox'),
      hidden: true,
      meta: {
        title: 'video-edit',
        roles: ['admin', 'staffProv',]
      }
    },
  ]
}

export default questionsAnswerRouter
