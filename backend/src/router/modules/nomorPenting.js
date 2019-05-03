/** When your routing table is too long, you can split it into small modules**/

import Layout from '@/layout'

const nomorPentingRouter = {
  path: '/nomor-penting',
  component: Layout,
  redirect: 'noredirect',
  name: 'NomorPenting',
  meta: {
    title: 'nomor-penting-manage',
    roles: ['admin'],
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
        roles: ['admin']
      }
    },
    {
      name: 'nomor-penting-edit',
      path: 'edit/:id',
      // component: () => import('@/views/nomorPenting/edit'),
      hidden: true,
      meta: {
        title: 'nomor-penting-edit',
        roles: ['admin']
      }
    },
    {
      name: 'nomor-penting-create',
      path: 'create',
      // component: () => import('@/views/nomorPenting/add'),
      meta: {
        title: 'nomor-penting-create',
        roles: ['admin']
      }
    }
  ]
}

export default nomorPentingRouter
