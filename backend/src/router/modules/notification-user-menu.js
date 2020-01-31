import Layout from '@/layout'
import popupInformasiRouter from './ListMenu/popupInformasi'
import bannerRouter from './ListMenu/banner'
import notificationRouter from './ListMenu/notification'

const notifikasiuserMenuRouter = {
  name: 'notification-user',
  path: 'notification-user',
  component: Layout,
  redirect: '/',
  meta: {
    title: 'notification-user',
    roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel'],
    icon: 'guide'
  },
  active: false,
  children: [
    ...bannerRouter,
    ...notificationRouter,
    ...popupInformasiRouter
  ]
}

export default notifikasiuserMenuRouter
