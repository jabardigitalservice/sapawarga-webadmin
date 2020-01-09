import Layout from '@/layout'

const broadcastRouter = {
  name: 'Broadcast',
  path: '/broadcast',
  component: Layout,
  redirect: '/broadcast/index',
  meta: {
    title: 'broadcast-manage',
    roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel'],
    icon: 'message'
  },
  active: false,
  children: [
    {
      name: 'broadcast-list',
      path: 'index',
      component: () => import('@/views/broadcast/list'),
      meta: {
        title: 'broadcast-list',
        roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel']
      }
    },
    {
      name: 'broadcast-create',
      path: 'create',
      component: () => import('@/views/broadcast/create'),
      meta: {
        title: 'broadcast-create',
        roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel']
      }
    },
    {
      path: 'edit/:id(\\d+)',
      component: () => import('@/views/broadcast/edit'),
      name: 'broadcast-edit',
      hidden: true,
      meta: {
        title: 'broadcast-edit',
        noCache: true,
        roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel']
      }
    },
    {
      name: 'broadcast-detail',
      path: 'detail/:id',
      component: () => import('@/views/broadcast/detail'),
      hidden: true,
      meta: {
        title: 'broadcast-detail',
        roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel']
      }
    }
  ]
}

export default broadcastRouter
