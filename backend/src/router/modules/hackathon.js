import Layout from '@/layout'

const hackathon = {
  name: 'hackathon',
  path: 'hackathon',
  component: Layout,
  redirect: '/',
  meta: {
    title: 'Laporan',
    roles: ['admin'],
    icon: 'qna'
  },
  active: false,
  children: [
    {
      name: 'hackathon',
      path: '/hackathon/index',
      component: () => import('@/views/hackathon/list'),
      meta: {
        title: 'Laporan',
        roles: ['admin']
      }
    }
  ]
}
export default hackathon
