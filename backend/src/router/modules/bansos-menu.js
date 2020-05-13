import Layout from '@/layout'

const bansosMenuRouter = {
  name: 'bansos-manage',
  path: 'bansos-manage',
  component: Layout,
  redirect: 'noredirect',
  meta: {
    title: 'bansos-menu',
    roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel'],
    icon: 'example'
  },
  active: false,
  children: [
    {
      name: 'beneficiaries-dashboard',
      path: '/beneficiaries/dashboard',
      component: () => import('@/views/beneficiaries/dashboard'),
      meta: {
        title: 'dashboard',
        roles: ['admin', 'staffProv']
      }
    },
    {
      name: 'beneficiaries-manage',
      path: '/beneficiaries/index',
      component: () => import('@/views/beneficiaries/list'),
      hidden: false,
      meta: {
        title: 'beneficiaries-list',
        roles: ['admin', 'staffKel']
      }
    },
    {
      name: 'beneficiaries-manage-bnba',
      path: '/beneficiaries/manage-bnba',
      component: () => import('@/views/beneficiaries/list-bnba'),
      hidden: false,
      meta: {
        title: 'beneficiaries-manage-bnba',
        roles: ['admin', 'staffProv']
      }
    },
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
    },
    {
      name: 'beneficiaries-create',
      path: '/beneficiaries/create',
      component: () => import('@/views/beneficiaries/create'),
      hidden: true,
      meta: {
        title: 'beneficiaries-create',
        roles: ['admin', 'staffKel']
      }
    },
    {
      path: '/beneficiaries/edit/:id(\\d+)',
      component: () => import('@/views/beneficiaries/edit'),
      name: 'beneficiaries-edit',
      hidden: true,
      meta: {
        title: 'beneficiaries-edit',
        noCache: true,
        roles: ['admin', 'staffKel']
      }
    },
    {
      name: 'beneficiaries-detail',
      path: '/beneficiaries/detail/:id',
      component: () => import('@/views/beneficiaries/components/Preview'),
      hidden: true,
      meta: {
        title: 'beneficiaries-detail',
        roles: ['admin', 'staffKel']
      }
    },
    {
      name: 'beneficiaries-verification',
      path: '/beneficiaries/verification/:id',
      component: () => import('@/views/beneficiaries/verification'),
      hidden: true,
      meta: {
        title: 'beneficiaries-verification',
        roles: ['admin', 'staffKel']
      }
    }
  ]
}

export default bansosMenuRouter
