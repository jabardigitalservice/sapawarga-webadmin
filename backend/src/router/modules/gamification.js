import Layout from '@/layout'

const gamificationRouter = {
  name: 'gamification',
  path: '/gamification',
  component: Layout,
  redirect: '/gamification/index',
  meta: {
    title: 'gamification-manage',
    roles: ['admin', 'staffProv'],
    icon: 'international'
  },
  active: false,
  children: [
    {
      name: 'gamification-list',
      path: 'index',
      component: () => import('@/views/gamification/list'),
      hidden: true,
      meta: {
        title: 'gamification-list',
        roles: ['admin', 'staffProv']
      }
    },
    {
      name: 'gamification-create',
      path: 'create',
      component: () => import('@/views/gamification/create'),
      hidden: true,
      meta: {
        title: 'gamification-create',
        roles: ['admin', 'staffProv']
      }
    },
    {
      name: 'gamification-edit',
      path: 'edit/:id',
      component: () => import('@/views/gamification/edit'),
      hidden: true,
      meta: {
        title: 'gamification-edit',
        roles: ['admin', 'staffProv']
      }
    },
    {
      name: 'gamification-detail',
      path: 'detail/:id',
      component: () => import('@/views/gamification/detail'),
      hidden: true,
      meta: {
        title: 'gamification-detail',
        roles: ['admin', 'staffProv']
      }
    }
  ]
}

export default gamificationRouter
