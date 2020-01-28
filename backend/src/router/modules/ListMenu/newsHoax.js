const newsHoaxRouter = [
  {
    name: 'information-newshoax',
    path: '/news-hoax/index',
    component: () => import('@/views/newsHoax/list'),
    meta: {
      title: 'news-hoax',
      roles: ['admin', 'staffSaberhoax', 'pimpinan']
    }
  },
  {
    name: 'newshoax-create',
    path: '/news-hoax/create',
    component: () => import('@/views/newsHoax/create'),
    hidden: true,
    meta: {
      title: 'news-hoax-create',
      roles: ['admin', 'staffSaberhoax']
    }
  },
  {
    name: 'newshoax-edit',
    path: '/news-hoax/edit/:id',
    component: () => import('@/views/newsHoax/edit'),
    hidden: true,
    meta: {
      title: 'news-hoax-edit',
      roles: ['admin', 'staffSaberhoax']
    }
  },
  {
    name: 'newshoax-detail',
    path: '/news-hoax/detail/:id',
    component: () => import('@/views/newsHoax/detail'),
    hidden: true,
    meta: {
      title: 'news-detail',
      roles: ['admin', 'staffSaberhoax']
    }
  }
]

export default newsHoaxRouter
