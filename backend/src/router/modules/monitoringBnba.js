import Layout from '@/layout'

const monitoringBnbaMenuRouter = {
  name: 'beneficiaries-monitoring-bnba',
  path: '/beneficiaries/monitoring',
  component: Layout,
  redirect: 'noredirect',
  meta: {
    title: 'beneficiaries-monitoring-bnba',
    roles: ['admin', 'staffProv'],
    icon: 'example'
  },
  active: false,
  children: [

    {
      name: 'beneficiaries-monitoring-bnba',
      path: '/beneficiaries/monitoring-bnba',
      component: () => import('@/views/beneficiaries/monitoringBnba'),
      hidden: false,
      meta: {
        title: 'beneficiaries-monitoring-bnba',
        roles: ['admin', 'staffProv']
      }
    }
  ]
}

export default monitoringBnbaMenuRouter
