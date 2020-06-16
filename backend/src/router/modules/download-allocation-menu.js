import Layout from '@/layout'

const downloadAllocationMenuRouter = {
  name: 'beneficiaries-monitoring-upload',
  path: '/beneficiaries/monitoring-upload',
  component: Layout,
  redirect: 'noredirect',
  meta: {
    title: 'beneficiaries-monitoring-upload',
    roles: ['admin', 'staffProv'],
    icon: 'example'
  },
  active: false,
  children: [

    {
      name: 'beneficiaries-monitoring-upload',
      path: '/beneficiaries/download-allocation',
      component: () => import('@/views/beneficiaries/monitoringUpload'),
      hidden: false,
      meta: {
        title: 'beneficiaries-monitoring-upload',
        roles: ['admin', 'staffProv']
      }
    }
  ]
}

export default downloadAllocationMenuRouter
