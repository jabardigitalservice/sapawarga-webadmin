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
      name: 'user-list',
      path: 'user-all',
      component: () => import('@/views/user/list'),
      props: {
        //
      },
      meta: {
        title: 'Semua Pengguna'
      }
    },
    {
      name: 'user-list-provinsi',
      path: 'user-provinsi',
      component: () => import('@/views/user/list'),
      props: {
        roleId: 'staffProv'
      },
      meta: {
        title: 'Provinsi',
        roles: ['admin']
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
        title: 'Kabupaten / Kota',
        roles: ['admin', 'staffProv']
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
        title: 'Kecamatan',
        roles: ['admin', 'staffProv', 'staffKabkota']
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
        title: 'Kelurahan',
        roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec']
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
        title: 'User Tingkat RW',
        roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel']
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
