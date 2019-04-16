/** When your routing table is too long, you can split it into small modules**/

import Layout from '@/layout'

const userRouter = {
  path: '/user',
  component: Layout,
  redirect: 'noredirect',
  name: 'User',
  meta: {
    title: 'User Management',
    icon: 'user'
  },
  children: [
    {
      path: 'user-list/kabkota',
      component: () => import('@/views/user/list'),
      props: {
        role: 'staffKabkota'
      },
      meta: {
        title: 'Kabupaten / Kota'
      }
    },
    {
      path: 'user-list/kecamatan',
      component: () => import('@/views/user/list'),
      props: {
        role: 'staffKec'
      },
      meta: {
        title: 'Kecamatan'
      }
    },
    {
      path: 'user-list/kelurahan',
      component: () => import('@/views/user/list'),
      props: {
        role: 'staffKel'
      },
      meta: {
        title: 'Kelurahan'
      }
    },
    {
      path: 'user-list/rw',
      component: () => import('@/views/user/list'),
      props: {
        role: 'staffRW'
      },
      meta: {
        title: 'User Tingkat RW'
      }
    },
    {
      path: 'user-add',
      component: () => import('@/views/user/add'),
      name: 'userAdd',
      meta: {
        title: 'User Add'
      }
    }
  ]
}

export default userRouter
