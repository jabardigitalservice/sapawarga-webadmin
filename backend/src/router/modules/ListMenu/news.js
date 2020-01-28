const newsRouter = [
  {
    name: 'information-news',
    path: '/news/index',
    component: () => import('@/views/news/list'),
    meta: {
      title: 'news-manage',
      roles: ['admin', 'staffProv', 'staffKabkota', 'pimpinan']
    }
  },
  {
    name: 'news-create',
    path: '/news/create',
    component: () => import('@/views/news/create'),
    hidden: true,
    meta: {
      title: 'news-create',
      roles: ['admin', 'staffProv', 'staffKabkota']
    }
  },
  {
    name: 'news-edit',
    path: '/news/edit/:id',
    component: () => import('@/views/news/edit'),
    hidden: true,
    meta: {
      title: 'news-edit',
      roles: ['admin', 'staffProv', 'staffKabkota']
    }
  },
  {
    name: 'news-detail',
    path: '/news/detail/:id',
    component: () => import('@/views/news/detail'),
    hidden: true,
    meta: {
      title: 'news-detail',
      roles: ['admin', 'staffProv', 'staffKabkota']
    }
  },
  {
    name: 'news-priority',
    path: '/news/priority',
    component: () => import('@/views/news/listPriority'),
    hidden: true,
    meta: {
      title: 'news-priority',
      roles: ['admin', 'staffProv', 'staffKabkota']
    }
  }
]

export default newsRouter
