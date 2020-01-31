const postRouter = [
  {
    name: 'aspiration-post-rw',
    path: '/post/index',
    component: () => import('@/views/post/list'),
    meta: {
      title: 'post-manage',
      roles: ['admin', 'staffProv']
    }
  },

  {
    name: 'post-detail',
    path: '/post/detail/:id',
    component: () => import('@/views/post/detail'),
    hidden: true,
    meta: {
      title: 'post-detail',
      roles: ['admin', 'staffProv']
    }
  }
]

export default postRouter
