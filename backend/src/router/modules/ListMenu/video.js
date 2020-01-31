const videoRouter = [
  {
    name: 'information-video',
    path: '/video/index',
    component: () => import('@/views/video/list'),
    meta: {
      title: 'video-manage',
      roles: ['admin', 'staffProv', 'staffKabkota']
    }
  },
  {
    name: 'video-create',
    path: '/video/create',
    component: () => import('@/views/video/create'),
    hidden: true,
    meta: {
      title: 'video-create',
      roles: ['admin', 'staffProv', 'staffKabkota']
    }
  },
  {
    name: 'video-edit',
    path: '/video/edit/:id',
    component: () => import('@/views/video/edit'),
    hidden: true,
    meta: {
      title: 'video-edit',
      roles: ['admin', 'staffProv', 'staffKabkota']
    }
  },
  {
    name: 'video-detail',
    path: '/video/detail/:id',
    component: () => import('@/views/video/detail'),
    hidden: true,
    meta: {
      title: 'video-detail',
      roles: ['admin', 'staffProv', 'staffKabkota']
    }
  }
]

export default videoRouter
