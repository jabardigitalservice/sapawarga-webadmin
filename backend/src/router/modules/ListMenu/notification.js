const notificationRouter = [
  {
    name: 'notification-user',
    path: '/notification/index',
    component: () => import('@/views/notification/list'),
    meta: {
      title: 'notification-manage',
      roles: ['admin', 'staffProv']
    }
  },
  {
    name: 'notification-create',
    path: '/notification/create',
    component: () => import('@/views/notification/create'),
    hidden: true,
    meta: {
      title: 'notification-create',
      roles: ['admin', 'staffProv']
    }
  },
  {
    path: '/notification/edit/:id(\\d+)',
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
    path: '/notification/show/:id',
    component: () => import('@/views/notification/show'),
    hidden: true,
    meta: {
      title: 'notification-show',
      roles: ['admin', 'staffProv']
    }
  }
]

export default notificationRouter
