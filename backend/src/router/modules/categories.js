import Layout from '@/layout'

const newsRouter = {
  name: 'Categories',
  path: '/categories',
  component: Layout,
  redirect: '/categories/index',
  meta: {
    title: 'categories-manage',
    roles: ['admin', 'staffProv', 'staffKabkota'],
    icon: 'documentation'
  },
  children: [
    {
      name: 'categories-list',
      path: 'index',
      component: () => import('@/views/categories/list'),
      meta: {
        title: 'categories-list',
        roles: ['admin', 'staffProv', 'staffKabkota']
      }
    },
    {
      name: 'categories-create',
      path: 'create',
      component: () => import('@/views/categories/create'),
      meta: {
        title: 'categories-create',
        roles: ['admin', 'staffProv', 'staffKabkota']
      }
    },
    {
      name: 'categories-edit',
      path: 'edit/:id',
      component: () => import('@/views/categories/edit'),
      hidden: true,
      meta: {
        title: 'categories-edit',
        roles: ['admin', 'staffProv', 'staffKabkota']
      }
    },
    {
      name: 'categories-detail',
      path: 'detail/:id',
      component: () => import('@/views/categories/detail'),
      hidden: true,
      meta: {
        title: 'categories-detail',
        roles: ['admin', 'staffProv', 'staffKabkota']
      }
    }
  ]
}

export default newsRouter
