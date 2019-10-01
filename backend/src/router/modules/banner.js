import Layout from '@/layout'

const bannerRouter = {
  name: 'Banner',
  path: '/banner',
  component: Layout,
  redirect: '/banner/index',
  meta: {
    title: 'banner-manage',
    roles: ['admin', 'staffProv'],
    icon: 'table'
  },
  children: [
    {
      name: 'banner-list',
      path: 'index',
      component: () => import('@/views/banner/list'),
      meta: {
        title: 'banner-list',
        roles: ['admin', 'staffProv']
      }
    },
    {
      name: 'banner-create',
      path: 'create',
      component: () => import('@/views/banner/create'),
      meta: {
        title: 'banner-create',
        roles: ['admin', 'staffProv']
      }
    },
    {
      path: 'edit/:id',
      component: () => import('@/views/banner/edit'),
      name: 'banner-edit',
      hidden: true,
      meta: {
        title: 'banner-edit',
        noCache: true,
        roles: ['admin', 'staffProv']
      }
    },
    {
      name: 'banner-detail',
      path: 'detail/:id',
      component: () => import('@/views/banner/detail'),
      hidden: true,
      meta: {
        title: 'banner-detail',
        roles: ['admin', 'staffProv']
      }
    }
  ]
}

export default bannerRouter
