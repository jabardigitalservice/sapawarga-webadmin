import Layout from '@/layout'

// const allocationMenuRouter = {
//   name: 'allocation-menu',
//   path: 'allocation-menu',
//   component: Layout,
//   redirect: 'noredirect',
//   meta: {
//     title: 'allocation-menu',
//     roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel'],
//     icon: 'example'
//   },
//   active: false,
//   children: [
//     {
//       name: 'beneficiaries-manage-bnba',
//       path: '/beneficiaries/manage-bnba',
//       component: () => import('@/views/beneficiaries/list-bnba'),
//       hidden: false,
//       meta: {
//         title: 'allocation-menu',
//         roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel']
//       }
//     }
//   ]
// }

const allocationMenuRouter = {
  name: 'allocation-menu',
  path: 'allocation-menu',
  component: Layout,
  redirect: 'noredirect',
  meta: {
    title: 'allocation-menu',
    roles: ['admin', 'staffKabkota'],
    icon: 'example'
  },
  active: false,
  children: [
    {
      name: 'bansos-download',
      path: '/allocation/download',
      component: () => import('@/views/bansos/download'),
      meta: {
        title: 'bansos-download',
        roles: ['admin', 'staffKabkota']
      }
    },
    {
      name: 'bansos-upload',
      path: '/allocation/upload',
      component: () => import('@/views/bansos/upload'),
      meta: {
        title: 'bansos-upload',
        roles: ['admin', 'staffKabkota']
      }
    }
  ]
}

export default allocationMenuRouter
