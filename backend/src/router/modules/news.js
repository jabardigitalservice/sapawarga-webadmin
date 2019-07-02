import Layout from '@/layout'

const newsRouter = {
  name: 'News',
  path: '/news',
  component: Layout,
  redirect: '/news/index',
  meta: {
    title: 'news-manage',
    roles: ['admin'],
    icon: 'documentation'
  },
  children: [
    {
      name: 'news-list',
      path: 'index',
      component: () => import('@/views/news/list'),
      meta: {
        title: 'news-list',
        roles: ['admin']
      }
    },
    {
      name: 'news-create',
      path: 'create',
      component: () => import('@/views/news/create'),
      meta: {
        title: 'news-create',
        roles: ['admin']
      }
    },
    {
      name: 'news-edit',
      path: 'edit/:id',
      component: () => import('@/views/news/edit'),
      hidden: true,
      meta: {
        title: 'news-edit',
        roles: ['admin']
      }
    },
    {
      name: 'news-detail',
      path: 'detail/:id',
      component: () => import('@/views/news/detail'),
      hidden: true,
      meta: {
        title: 'news-detail',
        roles: ['admin']
      }
    }
  ]
}

export default newsRouter
