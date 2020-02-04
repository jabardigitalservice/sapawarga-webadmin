import Layout from '@/layout'

const pollingLeaderMenuRouter = {
  name: 'polling',
  path: '/polling',
  component: Layout,
  redirect: '/polling/index',
  meta: {
    title: 'polling-manage',
    roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel', 'pimpinan'],
    icon: 'polling'
  },
  active: false,
  children: [
    {
      name: 'polling-list',
      path: 'index',
      component: () => import('@/views/polling/list'),
      meta: {
        title: 'polling-list',
        roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel', 'pimpinan']
      }
    },
    {
      name: 'polling-create',
      path: 'create',
      component: () => import('@/views/polling/create'),
      meta: {
        title: 'polling-create',
        roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel', 'pimpinan']
      }
    },
    {
      name: 'polling-edit',
      path: 'edit/:id',
      component: () => import('@/views/polling/edit'),
      hidden: true,
      meta: {
        title: 'polling-edit',
        roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel', 'pimpinan']
      }
    },
    {
      name: 'polling-detail',
      path: 'detail/:id',
      component: () => import('@/views/polling/detail'),
      hidden: true,
      meta: {
        title: 'polling-detail',
        roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel', 'pimpinan']
      }
    }
  ]
}

export default pollingLeaderMenuRouter