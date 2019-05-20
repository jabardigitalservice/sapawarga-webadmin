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
      name: 'aspiration-detail',
      path: 'detail/:id',
      component: () => import('@/views/aspiration/detail'),
      hidden: true,
      meta: {
        title: 'aspiration-detail',
        roles: ['admin']
      }
    }
  ]
}

export default aspirationRouter
