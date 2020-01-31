import Layout from '@/layout'
import aspirationRouter from './ListMenu/aspiration'
import qnaRouter from './ListMenu/qna'
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
    ...postRouter,
    ...qnaRouter,
    ...aspirationRouter
  ]
}

export default aspirationMenuRouter
