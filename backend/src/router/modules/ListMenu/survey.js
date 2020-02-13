const surveyRouter = [
  {
    name: 'questionnaire-menu',
    path: '/survey/index',
    component: () => import('@/views/survey/list'),
    meta: {
      title: 'survey-manage',
      roles: ['admin', 'staffProv', 'staffKabkota', 'pimpinan', 'staffOPD', 'staffKabkota']
    }
  },
  {
    name: 'survey-create',
    path: '/survey/create',
    component: () => import('@/views/survey/create'),
    hidden: true,
    meta: {
      title: 'survey-create',
      roles: ['admin', 'staffProv', 'pimpinan', 'staffOPD', 'staffKabkota']
    }
  },
  {
    name: 'survey-edit',
    path: '/survey/edit/:id',
    component: () => import('@/views/survey/edit'),
    hidden: true,
    meta: {
      title: 'survey-edit',
      roles: ['admin', 'staffProv', 'pimpinan', 'staffOPD', 'staffKabkota']
    }
  },
  {
    name: 'survey-detail',
    path: '/survey/detail/:id',
    component: () => import('@/views/survey/detail'),
    hidden: true,
    meta: {
      title: 'survey-detail',
      roles: ['admin', 'staffProv', 'staffKabkota', 'pimpinan', 'staffOPD', 'staffKabkota']
    }
  }
]

export default surveyRouter
