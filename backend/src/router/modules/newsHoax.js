import Layout from '@/layout'

const releaseManagementRouter = {
  name: 'News Hoax',
  path: '/news-hoax',
  component: Layout,
  redirect: '/news-hoax/index',
  meta: {
    title: 'News Hoax',
    roles: ['admin'],
    icon: 'zip'
  },
  children: [
    {
      name: 'news-hoax-list',
      path: 'index',
      component: () => import('@/views/newsHoax/list'),
      meta: {
        title: 'news-hoax-list',
        roles: ['admin']
      }
    },
  ]
}

export default releaseManagementRouter
