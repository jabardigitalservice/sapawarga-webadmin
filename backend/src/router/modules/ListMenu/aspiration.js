const aspirationRouter = [
  {
    name: 'aspiration-list',
    path: '/aspirasi/index',
    component: () => import('@/views/aspiration/list'),
    meta: {
      title: 'aspiration-manage',
      roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel', 'pimpinan']
    }
  },
  {
    name: 'aspiration-detail',
    path: '/aspirasi/detail/:id',
    component: () => import('@/views/aspiration/detail'),
    hidden: true,
    meta: {
      title: 'aspiration-detail',
      roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel']
    }
  }
]

export default aspirationRouter
