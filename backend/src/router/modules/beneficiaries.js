import Layout from '@/layout'

const beneficiariesRouter = {
  name: 'beneficiaries-manage',
  path: 'beneficiaries-manage',
  component: Layout,
  redirect: '/',
  meta: {
    title: 'beneficiaries-manage',
    roles: ['admin', 'staffKel'],
    icon: 'example'
  },
  active: false,
  children: [
    {
      name: 'beneficiaries-manage',
      path: '/beneficiaries/index',
      component: () => import('@/views/beneficiaries/list'),
      meta: {
        title: 'beneficiaries-manage',
        roles: ['admin', 'staffKel']
      }
    },
    {
      name: 'beneficiaries-create',
      path: '/beneficiaries/create',
      component: () => import('@/views/beneficiaries/create'),
      hidden: true,
      meta: {
        title: 'beneficiaries-create',
        roles: ['admin', 'staffKel']
      }
    },
    {
      path: '/beneficiaries/edit/:id(\\d+)',
      component: () => import('@/views/beneficiaries/edit'),
      name: 'beneficiaries-edit',
      hidden: true,
      meta: {
        title: 'beneficiaries-edit',
        noCache: true,
        roles: ['admin', 'staffKel']
      }
    },
    {
      name: 'beneficiaries-detail',
      path: '/beneficiaries/detail/:id',
      component: () => import('@/views/beneficiaries/detail'),
      hidden: true,
      meta: {
        title: 'beneficiaries-detail',
        roles: ['admin', 'staffKel']
      }
    }
  ]
}
export default beneficiariesRouter
