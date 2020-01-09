import Layout from '@/layout'

const videoRouter = {
  name: 'video',
  path: '/video',
  component: Layout,
  redirect: '/video/index',
  meta: {
    title: 'video-manage',
    roles: ['admin', 'staffProv', 'staffKabkota'],
    icon: 'international'
  },
  active: false,
  children: [
    {
      name: 'video-list',
      path: 'index',
      component: () => import('@/views/video/list'),
      meta: {
        title: 'video-list',
        roles: ['admin', 'staffProv', 'staffKabkota']
      }
    },
    {
      name: 'video-create',
      path: 'create',
      component: () => import('@/views/video/create'),
      meta: {
        title: 'video-create',
        roles: ['admin', 'staffProv', 'staffKabkota']
      }
    },
    {
      name: 'video-edit',
      path: 'edit/:id',
      component: () => import('@/views/video/edit'),
      hidden: true,
      meta: {
        title: 'video-edit',
        roles: ['admin', 'staffProv', 'staffKabkota']
      }
    },
    {
      name: 'video-detail',
      path: 'detail/:id',
      component: () => import('@/views/video/detail'),
      hidden: true,
      meta: {
        title: 'video-detail',
        roles: ['admin', 'staffProv', 'staffKabkota']
      }
    }
  ]
}

export default videoRouter
