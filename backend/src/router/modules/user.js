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
      name: 'user-list-provinsi',
      path: 'user-provinsi',
      component: () => import('@/views/user/list'),
      props: {
        roleId: 'staffProv'
      },
      meta: {
        title: 'Provinsi'
      }
    },
    {
      name: 'user-list-kabkota',
      path: 'user-kabkota',
      component: () => import('@/views/user/list'),
      props: {
        roleId: 'staffKabkota'
      },
      meta: {
        title: 'Kabupaten / Kota'
      }
    },
    {
      name: 'user-list-kecamatan',
      path: 'user-kecamatan',
      component: () => import('@/views/user/list'),
      props: {
        roleId: 'staffKec'
      },
      meta: {
        title: 'Kecamatan'
      }
    },
    {
      name: 'user-list-kelurahan',
      path: 'user-kelurahan',
      component: () => import('@/views/user/list'),
      props: {
        roleId: 'staffKel'
      },
      meta: {
        title: 'Kelurahan'
      }
    },
    {
      name: 'user-list-rw',
      path: 'user-rw',
      component: () => import('@/views/user/list'),
      props: {
        roleId: 'staffRW'
      },
      meta: {
        title: 'User Tingkat RW'
      }
    },
    {
      name: 'user-edit',
      path: 'edit/:id',
      component: () => import('@/views/user/add'), // @TODO ganti ke edit
      hidden: true,
      meta: {
        title: 'Edit'
      }
    },
    {
      name: 'create',
      path: 'create',
      component: () => import('@/views/user/add'),
      meta: {
        title: 'Tambah Pengguna Baru'
      }
    }
  ]
}

export default userRouter
