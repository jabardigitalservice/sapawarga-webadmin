import Layout from '@/layout'

const newsHoaxRouter = {
  name: 'news-hoax',
  path: '/news-hoax',
  component: Layout,
  redirect: '/news-hoax/index',
  meta: {
    title: 'news-hoax',
    roles: ['admin', 'staffSaberhoax'],
    icon: 'nested'
  },
  children: [
    {
      name: 'news-hoax-list',
      path: 'index',
      component: () => import('@/views/newsHoax/list'),
      meta: {
        title: 'news-hoax-list',
        roles: ['admin', 'staffSaberhoax']
      }
    },
    {
      name: 'news-hoax-create',
      path: 'create',
      component: () => import('@/views/newsHoax/create'),
      meta: {
        title: 'news-hoax-create',
        roles: ['admin', 'staffSaberhoax']
      }
    },
    {
      name: 'news-hoax-edit',
      path: 'edit/:id',
      component: () => import('@/views/newsHoax/edit'),
      hidden: true,
      meta: {
        title: 'news-hoax-edit',
        roles: ['admin', 'staffSaberhoax']
      }
    },
    {
      name: 'news-hoax-detail',
      path: 'detail/:id',
      component: () => import('@/views/newsHoax/detail'),
      hidden: true,
      meta: {
        title: 'news-detail',
        roles: ['admin', 'staffSaberhoax']
      }
    }
  ]
}

export default newsHoaxRouter
