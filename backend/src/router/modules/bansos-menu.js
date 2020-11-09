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
        title: 'beneficiaries-dashboard-verification',
        roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel']
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
      name: 'bansos-upload-form',
      path: '/bansos/upload-form',
      component: () => import('@/views/bansos/upload_form'),
      hidden: true,
      meta: {
        roles: ['admin', 'staffKabkota']
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
      name: 'beneficiaries-detail',
      path: '/beneficiaries/detail-verval/:id',
      component: () => import('@/views/beneficiaries/detailVerval'),
      hidden: true,
      meta: {
        title: 'beneficiaries-detail',
        roles: ['admin', 'staffKel', 'staffKec', 'staffKabkota']
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
    },
    {
      name: 'beneficiaries-pending',
      path: '/beneficiaries/pending',
      component: () => import('@/views/beneficiaries/pending'),
      hidden: false,
      meta: {
        title: 'beneficiaries-pending',
        roles: ['admin', 'staffProv', 'staffKel', 'staffKec', 'staffKabkota']
      }
    },
    {
      name: 'beneficiaries-approved',
      path: '/beneficiaries/approved',
      component: () => import('@/views/beneficiaries/approved'),
      hidden: false,
      meta: {
        title: 'beneficiaries-approved',
        roles: ['admin', 'staffProv', 'staffKel', 'staffKec', 'staffKabkota']
      }
    },
    {
      name: 'beneficiaries-download-verval',
      path: '/beneficiaries/download-verval',
      component: () => import('@/views/bansos/download'),
      hidden: false,
      meta: {
        title: 'bansos-download-verval',
        roles: ['staffKec']
      }
    },
    {
      name: 'beneficiaries-complaint',
      path: '/beneficiaries/complaint',
      component: () => import('@/views/beneficiaries/complaint'),
      hidden: false,
      meta: {
        title: 'benebeneficiaries-complaint',
        roles: ['admin', 'staffKel', 'staffKabkota']
      }
    },
    {
      name: 'benebeneficiaries-complaint-detail',
      path: '/beneficiaries/complaint/detail/:id',
      component: () => import('@/views/beneficiaries/complaintDetail'),
      hidden: true,
      meta: {
        title: 'beneficiaries-detail',
        roles: ['admin', 'staffKel', 'staffKabkota']
      }
    }
  ]
}

export default bansosMenuRouter
