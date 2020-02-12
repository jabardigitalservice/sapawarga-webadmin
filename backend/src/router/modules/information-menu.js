import Layout from '@/layout'
import nomorPentingRouter from './ListMenu/nomorPenting'
import newsRouter from './ListMenu/news'
import newsHoaxRouter from './ListMenu/newsHoax'
import videoRouter from './ListMenu/video'
import newsImportantRouter from './ListMenu/newsImportant'

const informationMenuRouter = {
  name: 'information',
  path: 'information',
  component: Layout,
  redirect: '/',
  meta: {
    title: 'information',
    roles: ['admin', 'staffProv', 'staffSaberhoax', 'staffKabkota', 'staffKec', 'staffKel', 'staffOPD'],
    icon: 'news'
  },
  active: false,
  children: [
    ...newsRouter,
    ...newsImportantRouter,
    ...newsHoaxRouter,
    ...nomorPentingRouter,
    ...videoRouter
  ]
}

export default informationMenuRouter
