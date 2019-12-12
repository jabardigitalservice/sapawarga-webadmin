import Layout from '@/layout'

const chatAdminRouter = {
  name: 'chat-admin-manage',
  path: '/chat-admin',
  component: Layout,
  redirect: '/chat-admin/index',
  meta: {
    title: 'chat-admin-manage',
    roles: ['admin', 'staffProv'],
    icon: 'message'
  },
  children: [
    {
      name: 'chat-admin-manage',
      path: 'index',
      component: () => import('@/views/chatAdmin/index'),
      hidden: true,
      meta: {
        title: 'chat-admin-list',
        roles: ['admin', 'staffProv']
      }
    }
  ]
}

export default chatAdminRouter
