import Layout from '@/layout'

const postRouter = {
  name: 'Post',
  path: '/post',
  component: Layout,
  redirect: '/post/index',
  meta: {
    title: 'post-manage',
    roles: ['admin', 'staffProv'],
    icon: 'example'
  },
  active: false,
  children: [
    {
      name: 'post-list',
      path: 'index',
      component: () => import('@/views/post/list'),
      meta: {
        title: 'post-list',
        roles: ['admin', 'staffProv']
      }
    },

    {
      name: 'post-detail',
      path: 'detail/:id',
      component: () => import('@/views/post/detail'),
      hidden: true,
      meta: {
        title: 'post-detail',
        roles: ['admin', 'staffProv']
      }
    }
  ]
}

export default postRouter
