import Layout from '@/layout'

const dashboardRouter = {
  name: 'Dashboard',
  path: '',
  component: Layout,
  redirect: 'dashboard',
  meta: {
    icon: 'home',
    roles: ['admin', 'staffProv', 'staffKabkota', 'pimpinan']
  },
  active: false,
  children: [
    {
      path: 'dashboard',
      component: () => import('@/views/dashboard/index'),
      name: 'Dashboard',
      meta: {
        title: 'dashboard',
        icon: 'home',
        noCache: true,
        affix: true,
        roles: ['admin', 'staffProv', 'staffKabkota', 'pimpinan']
      }
    }
  ]
}

export default dashboardRouter
