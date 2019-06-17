import Layout from '@/layout'

const pollingRouter = {
  name: 'Polling',
  path: '/polling',
  component: Layout,
  redirect: '/polling/index',
  meta: {
    title: 'polling-manage',
    roles: ['admin'],
    icon: 'peoples'
  },
  children: [
    {
      name: 'polling-list',
      path: 'index',
      component: () => import('@/views/polling/list'),
      meta: {
        title: 'polling-list',
        roles: ['admin']
      }
    },
    {
      name: 'polling-create',
      path: 'create',
      component: () => import('@/views/polling/create'),
      meta: {
        title: 'polling-create',
        roles: ['admin']
      }
    },
    {
      name: 'polling-edit',
      path: 'edit/:id',
      component: () => import('@/views/polling/edit'),
      hidden: true,
      meta: {
        title: 'polling-edit',
        roles: ['admin']
      }
    },
    {
      name: 'polling-detail',
      path: 'detail/:id',
      component: () => import('@/views/polling/detail'),
      hidden: true,
      meta: {
        title: 'polling-detail',
        roles: ['admin']
      }
    }
  ]
}

export default pollingRouter
