const pollingRouter = [
  {
    name: 'questionnaire-menu',
    path: '/polling/index',
    component: () => import('@/views/polling/list'),
    meta: {
      title: 'polling-manage',
      roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel', 'pimpinan', 'staffOPD']
    }
  },
  {
    name: 'polling-create',
    path: '/polling/create',
    component: () => import('@/views/polling/create'),
    hidden: true,
    meta: {
      title: 'polling-create',
      roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel', 'pimpinan', 'staffOPD']
    }
  },
  {
    name: 'polling-edit',
    path: '/polling/edit/:id',
    component: () => import('@/views/polling/edit'),
    hidden: true,
    meta: {
      title: 'polling-edit',
      roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel', 'pimpinan', 'staffOPD']
    }
  },
  {
    name: 'polling-detail',
    path: '/polling/detail/:id',
    component: () => import('@/views/polling/detail'),
    hidden: true,
    meta: {
      title: 'polling-detail',
      roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel', 'pimpinan', 'staffOPD']
    }
  }
]

export default pollingRouter
