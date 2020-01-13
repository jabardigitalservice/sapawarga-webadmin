import Layout from '@/layout'

const newsImportantRouter = {
  name: 'News Important',
  path: '/news-important',
  component: Layout,
  redirect: '/news-important/index',
  meta: {
    title: 'news-important-manage',
    roles: ['admin', 'staffProv', 'staffOPD'],
    icon: 'documentation'
  },
  active: false,
  children: [
    {
      name: 'news-important',
      path: 'index',
      component: () => import('@/views/newsImportant/list'),
      meta: {
        title: 'news-important-list',
        roles: ['admin', 'staffProv', 'staffOPD']
      }
    },
    {
      name: 'news-important-create',
      path: 'create',
      component: () => import('@/views/newsImportant/create'),
      meta: {
        title: 'news-important-create',
        roles: ['admin', 'staffProv', 'staffOPD']
      }
    },
    {
      name: 'news-important-edit',
      path: 'edit/:id',
      component: () => import('@/views/newsImportant/edit'),
      hidden: true,
      meta: {
        title: 'news-important-edit',
        roles: ['admin', 'staffProv', 'staffOPD']
      }
    },
    {
      name: 'news-important-detail',
      path: 'detail/:id',
      component: () => import('@/views/newsImportant/detail'),
      hidden: true,
      meta: {
        title: 'news-important-detail',
        roles: ['admin', 'staffProv', 'staffOPD']
      }
    }
  ]
}

export default newsImportantRouter
