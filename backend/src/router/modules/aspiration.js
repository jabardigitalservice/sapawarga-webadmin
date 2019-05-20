import Layout from '@/layout'

const aspirationRouter = {
  name: 'Aspiration',
  path: '/aspirasi',
  component: Layout,
  redirect: '/aspirasi/index',
  meta: {
    title: 'aspiration-manage',
    roles: ['admin'],
    icon: 'dashboard'
  },
  children: [
    {
      name: 'aspiration-list',
      path: 'index',
      component: () => import('@/views/aspiration/list'),
      meta: {
        title: 'aspiration-list',
        roles: ['admin']
      }
    },
    {
      name: 'aspiration-create',
      path: 'create',
      component: () => import('@/views/aspiration/create'),
      meta: {
        title: 'aspiration-create',
        roles: ['admin']
      }
    },
    {
      path: 'edit/:id(\\d+)',
      component: () => import('@/views/aspiration/create'),
      name: 'aspiration-edit',
      hidden: true,
      meta: {
        title: 'aspiration-edit',
        noCache: true,
        roles: ['admin']
      }
    },
    {
      name: 'aspiration-show',
      path: 'show/:id',
      component: () => import('@/views/aspiration/create'),
      hidden: true,
      meta: {
        title: 'aspiration-show',
        roles: ['admin']
      }
    }
  ]
}

export default aspirationRouter
