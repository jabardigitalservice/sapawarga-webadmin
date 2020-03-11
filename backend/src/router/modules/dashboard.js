import Layout from '@/layout'

const dashboardRouter = {
  name: 'dashboard',
  path: 'dahboard',
  component: Layout,
  redirect: '/',
  meta: {
    icon: 'home',
    roles: ['admin', 'staffProv', 'staffKabkota', 'pimpinan']
  },
  active: false,
  children: [
    {
      path: '/dashboard',
      component: () => import('@/views/dashboard/index'),
      name: 'dashboard',
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
