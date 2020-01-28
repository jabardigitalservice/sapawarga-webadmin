/** When your routing table is too long, you can split it into small modules**/
const nomorPentingRouter = [
  {
    name: 'information-important-number',
    path: '/nomor-penting/index',
    component: () => import('@/views/nomorPenting/list'),
    meta: {
      title: 'nomor-penting-manage',
      roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel']
    }
  },
  {
    path: '/nomor-penting/create',
    component: () => import('@/views/nomorPenting/create'),
    name: 'nomor-penting-create',
    hidden: true,
    meta: {
      title: 'nomor-penting-create',
      roles: ['admin', 'staffProv', 'staffKabkota']
    }
  },
  {
    path: '/nomor-penting/edit/:id(\\d+)',
    component: () => import('@/views/nomorPenting/edit'),
    name: 'nomor-penting-edit',
    hidden: true,
    meta: {
      title: 'nomor-penting-edit',
      noCache: true,
      roles: ['admin', 'staffProv', 'staffKabkota']
    }
  },
  {
    name: 'nomor-penting-show',
    path: '/nomor-penting/show/:id',
    component: () => import('@/views/nomorPenting/show'),
    hidden: true,
    meta: {
      title: 'nomor-penting-detail',
      roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel']
    }
  }
]

export default nomorPentingRouter
