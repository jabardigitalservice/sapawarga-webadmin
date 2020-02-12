import Layout from '@/layout'

const broadcastRouter = {
  name: 'broadcast-manage',
  path: 'broadcast-manage',
  component: Layout,
  redirect: '/',
  meta: {
    title: 'broadcast-manage',
    roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel', 'staffOPD'],
    icon: 'qna'
  },
  active: false,
  children: [
    {
      name: 'broadcast-list',
      path: '/broadcast/index',
      component: () => import('@/views/broadcast/list'),
      meta: {
        title: 'broadcast-manage',
        roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel', 'staffOPD']
      }
    },
    {
      name: 'broadcast-create',
      path: '/broadcast/create',
      component: () => import('@/views/broadcast/create'),
      hidden: true,
      meta: {
        title: 'broadcast-create',
        roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel', 'staffOPD']
      }
    },
    {
      path: '/broadcast/edit/:id(\\d+)',
      component: () => import('@/views/broadcast/edit'),
      name: 'broadcast-edit',
      hidden: true,
      meta: {
        title: 'broadcast-edit',
        noCache: true,
        roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel', 'staffOPD']
      }
    },
    {
      name: 'broadcast-detail',
      path: '/broadcast/detail/:id',
      component: () => import('@/views/broadcast/detail'),
      hidden: true,
      meta: {
        title: 'broadcast-detail',
        roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel', 'staffOPD']
      }
    }
  ]
}
export default broadcastRouter
