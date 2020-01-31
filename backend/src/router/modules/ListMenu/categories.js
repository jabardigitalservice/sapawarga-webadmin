const categoriesRouter = [
  {
    name: 'categories-manage',
    path: '/categories/index',
    component: () => import('@/views/categories/list'),
    meta: {
      title: 'categories-manage',
      roles: ['admin', 'staffProv']
    }
  },
  {
    name: 'categories-create',
    path: '/categories/create',
    component: () => import('@/views/categories/create'),
    hidden: true,
    meta: {
      title: 'categories-create',
      roles: ['admin', 'staffProv']
    }
  },
  {
    name: 'categories-edit',
    path: '/categories/edit/:id',
    component: () => import('@/views/categories/edit'),
    hidden: true,
    meta: {
      title: 'categories-edit',
      roles: ['admin', 'staffProv']
    }
  }
]

export default categoriesRouter
