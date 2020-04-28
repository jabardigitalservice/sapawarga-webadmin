import Layout from '@/layout'

const bansosMenuRouter = {
  name: 'bansos-manage',
  path: 'bansos-manage',
  component: Layout,
  redirect: 'noredirect',
  meta: {
    title: 'bansos-menu',
    roles: ['admin', 'staffProv', 'staffKabkota'],
    icon: 'news'
  },
  active: false,
  children: [
    {
      name: 'bansos-download',
      path: '/bansos/download',
      component: () => import('@/views/bansos/download'),
      meta: {
        title: 'bansos-download',
        roles: ['admin', 'staffProv', 'staffKabkota']
      }
    },
    {
      name: 'bansos-upload',
      path: '/bansos/upload',
      component: () => import('@/views/bansos/upload'),
      meta: {
        title: 'bansos-upload',
        roles: ['admin', 'staffProv', 'staffKabkota']
      }
    },
    {
      name: 'bansos-upload-form',
      path: '/bansos/upload-form',
      component: () => import('@/views/bansos/upload_form'),
      hidden: true,
      meta: {
        roles: ['admin', 'staffProv', 'staffKabkota']
      }
    }
  ]
}

export default bansosMenuRouter
