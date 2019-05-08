/** When your routing table is too long, you can split it into small modules**/

import Layout from '@/layout'

const nomorPentingRouter = {
  path: '/nomor-penting',
  component: Layout,
  redirect: '/nomor-penting/index',
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
      meta: {
        title: 'nomor-penting-create',
        roles: ['admin']
      }
    },
    {
      path: 'edit/:id(\\d+)',
      component: () => import('@/views/nomorPenting/edit'),
      name: 'nomor-penting-edit',
      meta: {
        title: 'nomor-penting-edit',
        noCache: true,
        roles: ['admin']
<<<<<<< HEAD
      }
    },
    {
      name: 'nomor-penting-show',
      path: 'show/:id',
      component: () => import('@/views/nomorPenting/show'),
      hidden: true,
      meta: {
        title: 'Detail no penting',
        roles: ['admin']
      }
=======
      },
      hidden: true
>>>>>>> 719702a23bc4d658ccfd26d3050a9c8206cb903e
    }
  ]
}

export default nomorPentingRouter
