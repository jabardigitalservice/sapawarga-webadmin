import Layout from '@/layout'
import nomorPentingRouter from './ListMenu/nomorPenting'
import broadcastRouter from './ListMenu/broadcast'
import newsRouter from './ListMenu/news'
import newsHoaxRouter from './ListMenu/newsHoax'
import videoRouter from './ListMenu/video'
import popupInformasiRouter from './ListMenu/popupInformasi'
import bannerRouter from './ListMenu/banner'
import newsImportantRouter from './ListMenu/newsImportant'
import notificationRouter from './ListMenu/notification'

const informationMenuRouter = {
  name: 'information',
  path: 'information',
  component: Layout,
  redirect: '/',
  meta: {
    title: 'information',
    roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel'],
    icon: 'news'
  },
  active: false,
  children: [
    ...nomorPentingRouter,
    ...broadcastRouter,
    ...newsRouter,
    ...newsHoaxRouter,
    ...videoRouter,
    ...popupInformasiRouter,
    ...bannerRouter,
    ...newsImportantRouter,
    ...notificationRouter
  ]
}

export default informationMenuRouter
