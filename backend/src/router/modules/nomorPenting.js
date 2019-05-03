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
      path: 'create',
      component: () => import('@/views/nomorPenting/create'),
      name: 'nomor-penting-create',
      meta: { title: 'nomor-penting-create' }
    },
    {
      path: 'edit/:id(\\d+)',
      component: () => import('@/views/nomorPenting/edit'),
      name: 'nomor-penting-edit',
      meta: { title: 'nomor-penting-edit', noCache: true },
      hidden: true
    }
  ]
}

export default nomorPentingRouter
