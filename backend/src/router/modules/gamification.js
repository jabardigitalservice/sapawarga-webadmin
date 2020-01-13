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
    }
  ]
}

export default gamificationRouter
