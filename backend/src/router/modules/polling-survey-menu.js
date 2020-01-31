import Layout from '@/layout'
import pollingRouter from './ListMenu/polling'
import surveyRouter from './ListMenu/survey'

const notifikasiuserMenuRouter = {
  name: 'pollingsurvey',
  path: 'pollingsurvey',
  component: Layout,
  redirect: '/',
  meta: {
    title: 'pollingsurvey',
    roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel'],
    icon: 'survey'
  },
  active: false,
  children: [
    ...pollingRouter,
    ...surveyRouter
  ]
}

export default notifikasiuserMenuRouter
