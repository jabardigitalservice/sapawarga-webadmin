import Layout from '@/layout'

const newsRouter = {
  name: 'Categories',
  path: '/categories',
  component: Layout,
  redirect: '/categories/index',
  meta: {
    title: 'categories-manage',
    roles: ['admin', 'staffProv', 'staffSaberhoax'],
    icon: 'documentation'
  },
  children: [
    {
      name: 'categories-list',
      path: 'index',
      component: () => import('@/views/categories/list'),
      meta: {
        title: 'categories-list',
        roles: ['admin', 'staffProv', 'staffSaberhoax']
      }
    },
    {
      name: 'categories-create',
      path: 'create',
      component: () => import('@/views/categories/create'),
      meta: {
        title: 'categories-create',
        roles: ['admin', 'staffProv', 'staffSaberhoax']
      }
    },
    {
      name: 'categories-edit',
      path: 'edit/:id',
      component: () => import('@/views/categories/edit'),
      hidden: true,
      meta: {
        title: 'categories-edit',
        roles: ['admin', 'staffProv', 'staffSaberhoax']
      }
    }
  ]
}

export default newsRouter
