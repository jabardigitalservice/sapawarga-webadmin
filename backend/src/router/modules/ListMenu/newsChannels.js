const newsChannelRouter = [
  {
    name: 'news-channels-manage',
    path: '/news-channels/index',
    component: () => import('@/views/newsChannels/list'),
    meta: {
      title: 'news-channels-manage',
      roles: ['admin', 'staffProv']
    }
  },
  {
    name: 'channels-news-create',
    path: '/news-channels/create',
    component: () => import('@/views/newsChannels/create'),
    hidden: true,
    meta: {
      title: 'news-channels-create',
      roles: ['admin', 'staffProv']
    }
  }
]

export default newsChannelRouter
