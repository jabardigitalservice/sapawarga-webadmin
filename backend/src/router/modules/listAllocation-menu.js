import Layout from '@/layout'

const listAllocationMenuRouter = {
  name: 'list-allocation-menu',
  path: 'list-allocation-menu',
  component: Layout,
  redirect: 'noredirect',
  meta: {
    title: 'list-allocation-menu',
    roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel'],
    icon: 'example'
  },
  active: false,
  children: [
    {
      name: 'beneficiaries-manage-bnba',
      path: '/beneficiaries/list-allocation',
      component: () => import('@/views/beneficiaries/list-bnba'),
      hidden: false,
      meta: {
        title: 'list-allocation-menu',
        roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel']
      }
    }
  ]
}

export default listAllocationMenuRouter