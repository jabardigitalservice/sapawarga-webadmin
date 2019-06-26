import Layout from '@/layout'

const surveyRouter = {
  name: 'survey',
  path: '/survey',
  component: Layout,
  redirect: '/survey/index',
  meta: {
    title: 'survey-manage',
    roles: ['admin'],
    icon: 'clipboard'
  },
  children: [
    {
      name: 'survey-list',
      path: 'index',
      component: () => import('@/views/survey/list'),
      meta: {
        title: 'survey-list',
        roles: ['admin']
      }
    },
    {
      name: 'survey-create',
      path: 'create',
      component: () => import('@/views/survey/create'),
      meta: {
        title: 'survey-create',
        roles: ['admin']
      }
    },
    {
      name: 'survey-edit',
      path: 'edit/:id',
      component: () => import('@/views/survey/edit'),
      hidden: true,
      meta: {
        title: 'survey-edit',
        roles: ['admin']
      }
    },
    {
      name: 'survey-detail',
      path: 'detail/:id',
      component: () => import('@/views/survey/detail'),
      hidden: true,
      meta: {
        title: 'survey-detail',
        roles: ['admin']
      }
    }
  ]
}

export default surveyRouter
