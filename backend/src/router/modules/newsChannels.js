import Layout from '@/layout'

const newsRouter = {
  name: 'News Channels',
  path: '/news-channels',
  component: Layout,
  redirect: '/news-channels/index',
  meta: {
    title: 'news-channels-manage',
    roles: ['admin', 'staffProv'],
    icon: 'documentation'
  },
  active: false,
  children: [
    {
      name: 'channels-news-list',
      path: 'index',
      component: () => import('@/views/newsChannels/list'),
      meta: {
        title: 'news-channels-list',
        roles: ['admin', 'staffProv']
      }
    },
    {
      name: 'channels-news-create',
      path: 'create',
      component: () => import('@/views/newsChannels/create'),
      meta: {
        title: 'news-channels-create',
        roles: ['admin', 'staffProv']
      }
    }
  ]
}

export default newsRouter
