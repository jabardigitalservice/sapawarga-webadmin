const qnaRouter = [
  {
    name: 'aspiration-qna-manage',
    path: '/question-answer/index',
    component: () => import('@/views/questionsAnswer/index'),
    meta: {
      title: 'question-answer-manage',
      roles: ['admin', 'staffProv', 'pimpinan']
    }
  },
  {
    name: 'question-answer',
    path: '/question-answer/messages/:id',
    component: () => import('@/views/questionsAnswer/message'),
    hidden: true,
    meta: {
      title: 'question-answer-message',
      roles: ['admin', 'staffProv', 'pimpinan']
    }
  }
]

export default qnaRouter
