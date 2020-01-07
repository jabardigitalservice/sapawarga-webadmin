import Layout from '@/layout'

const dashboardRouter = {
  path: '',
  component: Layout,
  redirect: 'dashboard',
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
