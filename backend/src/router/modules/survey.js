import Layout from '@/layout'

const surveyRouter = {
  name: 'survey',
  path: '/survey',
  component: Layout,
  redirect: '/survey/index',
  meta: {
    title: 'survey-manage',
    roles: ['admin', 'staffProv', 'staffKabkota'],
    icon: 'clipboard'
  },
  children: [
    {
      name: 'survey-list',
      path: 'index',
      component: () => import('@/views/survey/list'),
      meta: {
        title: 'survey-list',
        roles: ['admin', 'staffProv', 'staffKabkota']
      }
    },
    {
      name: 'survey-create',
      path: 'create',
      component: () => import('@/views/survey/create'),
      meta: {
        title: 'survey-create',
        roles: ['admin', 'staffProv']
      }
    },
    {
      name: 'survey-edit',
      path: 'edit/:id',
      component: () => import('@/views/survey/edit'),
      hidden: true,
      meta: {
        title: 'survey-edit',
        roles: ['admin', 'staffProv']
      }
    },
    {
      name: 'survey-detail',
      path: 'detail/:id',
      component: () => import('@/views/survey/detail'),
      hidden: true,
      meta: {
        title: 'survey-detail',
        roles: ['admin', 'staffProv', 'staffKabkota']
      }
    }
  ]
}

export default surveyRouter
