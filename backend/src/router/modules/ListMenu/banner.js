const bannerRouter = [
  {
    name: 'notification-user',
    path: '/banner/index',
    component: () => import('@/views/banner/list'),
    meta: {
      title: 'banner-manage',
      roles: ['admin', 'staffProv']
    }
  },
  {
    name: 'banner-create',
    path: '/banner/create',
    component: () => import('@/views/banner/create'),
    hidden: true,
    meta: {
      title: 'banner-create',
      roles: ['admin', 'staffProv']
    }
  },
  {
    path: '/banner/edit/:id',
    component: () => import('@/views/banner/edit'),
    name: '/banner/banner-edit',
    hidden: true,
    meta: {
      title: 'banner-edit',
      noCache: true,
      roles: ['admin', 'staffProv']
    }
  },
  {
    name: 'banner-detail',
    path: '/banner/detail/:id',
    component: () => import('@/views/banner/detail'),
    hidden: true,
    meta: {
      title: 'banner-detail',
      roles: ['admin', 'staffProv']
    }
  }
]

export default bannerRouter
