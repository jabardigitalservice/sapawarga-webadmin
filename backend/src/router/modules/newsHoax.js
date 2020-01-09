import Layout from '@/layout'

const newsHoaxRouter = {
  name: 'newshoax',
  path: '/news-hoax',
  component: Layout,
  redirect: '/news-hoax/index',
  meta: {
    title: 'news-hoax',
    roles: ['admin', 'staffSaberhoax', 'pimpinan'],
    icon: 'saberhoax'
  },
  active: false,
  children: [
    {
      name: 'newshoax-list',
      path: 'index',
      component: () => import('@/views/newsHoax/list'),
      meta: {
        title: 'news-hoax-list',
        roles: ['admin', 'staffSaberhoax', 'pimpinan']
      }
    },
    {
      name: 'newshoax-create',
      path: 'create',
      component: () => import('@/views/newsHoax/create'),
      meta: {
        title: 'news-hoax-create',
        roles: ['admin', 'staffSaberhoax']
      }
    },
    {
      name: 'newshoax-edit',
      path: 'edit/:id',
      component: () => import('@/views/newsHoax/edit'),
      hidden: true,
      meta: {
        title: 'news-hoax-edit',
        roles: ['admin', 'staffSaberhoax']
      }
    },
    {
      name: 'newshoax-detail',
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
