import Layout from '@/layout'
import pollingRouter from './ListMenu/polling'
import surveyRouter from './ListMenu/survey'

const notifikasiuserMenuRouter = {
  name: 'questionnaire',
  path: 'pollingsurvey',
  component: Layout,
  redirect: 'noredirect',
  meta: {
    title: 'questionnaire',
    roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel', 'staffOPD'],
    icon: 'survey'
  },
  active: false,
  children: [
    ...pollingRouter,
    ...surveyRouter
  ]
}

export default notifikasiuserMenuRouter
