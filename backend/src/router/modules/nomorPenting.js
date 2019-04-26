/** When your routing table is too long, you can split it into small modules**/

import Layout from '@/layout'

const nomorPentingRouter = {
  path: '/nomor-penting',
  component: Layout,
  redirect: 'noredirect',
  name: 'NomorPenting',
  meta: {
    title: 'Kelola Nomor Penting',
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
        title: 'Daftar Nomor Penting'
      }
    }
  ]
}

export default nomorPentingRouter
