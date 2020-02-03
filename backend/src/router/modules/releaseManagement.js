import Layout from '@/layout'

const releaseManagementRouter = {
  name: 'release-management',
  path: '/release-management',
  component: Layout,
  redirect: '/release-management/index',
  meta: {
    title: 'Release Management',
    roles: ['admin'],
    icon: 'zip'
  },
  active: false,
  children: [
    {
      name: 'release-management-list',
      path: 'index',
      component: () => import('@/views/releaseManagement/list'),
      hidden: true,
      meta: {
        title: 'release-management-list',
        roles: ['admin']
      }
    },
    {
      name: 'release-management-create',
      path: 'create',
      component: () => import('@/views/releaseManagement/create'),
      hidden: true,
      meta: {
        title: 'release-management-create',
        roles: ['admin']
      }
    },
    {
      name: 'release-management-edit',
      path: 'edit/:id',
      component: () => import('@/views/releaseManagement/edit'),
      hidden: true,
      meta: {
        title: 'release-management-edit',
        roles: ['admin']
      }
    }
  ]
}

export default releaseManagementRouter
