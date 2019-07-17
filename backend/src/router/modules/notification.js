import Layout from '@/layout'

const notificationRouter = {
  name: 'Notification',
  path: '/notification',
  component: Layout,
  redirect: '/notification/index',
  meta: {
    title: 'notification-manage',
    roles: ['admin', 'staffProv'],
    icon: 'email'
  },
  children: [
    {
      name: 'notification-list',
      path: 'index',
      component: () => import('@/views/notification/list'),
      meta: {
        title: 'notification-list',
        roles: ['admin', 'staffProv']
      }
    },
    {
      name: 'notification-create',
      path: 'create',
      component: () => import('@/views/notification/create'),
      meta: {
        title: 'notification-create',
        roles: ['admin', 'staffProv']
      }
    },
    {
      path: 'edit/:id(\\d+)',
      component: () => import('@/views/notification/edit'),
      name: 'notification-edit',
      hidden: true,
      meta: {
        title: 'notification-edit',
        noCache: true,
        roles: ['admin', 'staffProv']
      }
    },
    {
      name: 'notification-show',
      path: 'show/:id',
      component: () => import('@/views/notification/show'),
      hidden: true,
      meta: {
        title: 'notification-show',
        roles: ['admin', 'staffProv']
      }
    }
  ]
}

export default notificationRouter
