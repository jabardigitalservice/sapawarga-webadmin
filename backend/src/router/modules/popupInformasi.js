import Layout from '@/layout'

const popupInformasiRouter = {
  name: 'Pop-Up Informasi',
  path: '/popup-informasi',
  component: Layout,
  redirect: '/popup-informasi/index',
  meta: {
    title: 'popup-informasi-manage',
    roles: ['admin', 'staffProv'],
    icon: 'table'
  },
  children: [
    {
      name: 'popup-informasi-list',
      path: 'index',
      component: () => import('@/views/popupInformasi/list'),
      meta: {
        title: 'popup-informasi-list',
        roles: ['admin', 'staffProv']
      }
    },
    {
      name: 'popup-informasi-create',
      path: 'create',
      component: () => import('@/views/popupInformasi/create'),
      meta: {
        title: 'popup-informasi-create',
        roles: ['admin', 'staffProv']
      }
    },
    {
      path: 'edit/:id',
      component: () => import('@/views/popupInformasi/edit'),
      name: 'popup-informasi-edit',
      hidden: true,
      meta: {
        title: 'popup-informasi-edit',
        noCache: true,
        roles: ['admin', 'staffProv']
      }
    },
    {
      name: 'popup-informasi-detail',
      path: 'detail/:id',
      component: () => import('@/views/popupInformasi/detail'),
      hidden: true,
      meta: {
        title: 'popup-informasi-detail',
        roles: ['admin', 'staffProv']
      }
    }
  ]
}

export default popupInformasiRouter
