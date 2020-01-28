import Layout from '@/layout'
import pollingRouter from './ListMenu/polling'
import aspirationRouter from './ListMenu/aspiration'
import qnaRouter from './ListMenu/qna'
import surveyRouter from './ListMenu/survey'
import postRouter from './ListMenu/post'

const aspirationMenuRouter = {
  name: 'aspiration',
  path: 'aspiration',
  component: Layout,
  redirect: '/',
  meta: {
    title: 'aspiration',
    roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel', 'pimpinan'],
    icon: 'aspiration'
  },
  active: false,
  children: [
    ...pollingRouter,
    ...aspirationRouter,
    ...qnaRouter,
    ...surveyRouter,
    ...postRouter
  ]
}

export default aspirationMenuRouter
