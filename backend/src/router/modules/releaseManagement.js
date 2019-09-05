import Layout from '@/layout'

const releaseManagementRouter = {
  name: 'release-management',
  path: '/release-management',
  component: Layout,
  redirect: '/release-management/index',
  meta: {
    title: 'Relese Management',
    roles: ['admin', 'staffProv', 'staffKabkota'],
    icon: 'zip'
  },
  children: [
    {
      name: 'release-management-list',
      path: 'index',
      component: () => import('@/views/releaseManagement/list'),
      meta: {
        title: 'release-management-list',
        roles: ['admin', 'staffProv', 'staffKabkota']
      }
    },
    {
      name: 'release-management-create',
      path: 'create',
      component: () => import('@/views/releaseManagement/create'),
      meta: {
        title: 'release-management-create',
        roles: ['admin', 'staffProv', 'staffKabkota']
      }
    },
    {
      name: 'release-management-edit',
      path: 'edit/:id',
      component: () => import('@/views/releaseManagement/edit'),
      hidden: true,
      meta: {
        title: 'release-management-edit',
        roles: ['admin', 'staffProv', 'staffKabkota']
      }
    }
  ]
}

export default releaseManagementRouter
