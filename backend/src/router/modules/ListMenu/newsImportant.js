const newsImportantRouter = [
  {
    name: 'information-ews-important',
    path: '/news-important/index',
    component: () => import('@/views/newsImportant/list'),
    meta: {
      title: 'news-important-manage',
      roles: ['admin', 'staffProv', 'staffOPD']
    }
  },
  {
    name: 'news-important-create',
    path: '/news-important/create',
    component: () => import('@/views/newsImportant/create'),
    hidden: true,
    meta: {
      title: 'news-important-create',
      roles: ['admin', 'staffProv', 'staffOPD']
    }
  },
  {
    name: 'news-important-edit',
    path: '/news-important/edit/:id',
    component: () => import('@/views/newsImportant/edit'),
    hidden: true,
    meta: {
      title: 'news-important-edit',
      roles: ['admin', 'staffProv', 'staffOPD']
    }
  },
  {
    name: 'news-important-detail',
    path: '/news-important/detail/:id',
    component: () => import('@/views/newsImportant/detail'),
    hidden: true,
    meta: {
      title: 'news-important-detail',
      roles: ['admin', 'staffProv', 'staffOPD']
    }
  }
]

export default newsImportantRouter
