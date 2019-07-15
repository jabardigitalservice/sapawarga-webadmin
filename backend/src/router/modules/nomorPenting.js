/** When your routing table is too long, you can split it into small modules**/

import Layout from '@/layout'

const nomorPentingRouter = {
  path: '/nomor-penting',
  component: Layout,
  redirect: '/nomor-penting/index',
  name: 'NomorPenting',
  meta: {
    title: 'nomor-penting-manage',
    roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel'],
    icon: 'list'
  },
  children: [
    {
      name: 'nomor-penting-list',
      path: 'index',
      component: () => import('@/views/nomorPenting/list'),
      props: {
        //
      },
      meta: {
        title: 'Daftar Nomor Penting',
        roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel']
      }
    },
    {
      path: 'create',
      component: () => import('@/views/nomorPenting/create'),
      name: 'nomor-penting-create',
      meta: {
        title: 'nomor-penting-create',
        roles: ['admin', 'staffProv', 'staffKabkota']
      }
    },
    {
      path: 'edit/:id(\\d+)',
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
      path: 'show/:id',
      component: () => import('@/views/nomorPenting/show'),
      hidden: true,
      meta: {
        title: 'nomor-penting-detail',
        roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel']
      }
    }
  ]
}

export default nomorPentingRouter
