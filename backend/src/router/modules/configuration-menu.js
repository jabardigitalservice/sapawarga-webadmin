import Layout from '@/layout'
import categoriesRouter from './ListMenu/categories'
import newsChannelRouter from './ListMenu/newsChannels'

const configurationMenuRouter = {
  name: 'configuration-menu',
  path: 'configuration-menu',
  component: Layout,
  redirect: '/',
  meta: {
    title: 'configuration-menu',
    roles: ['admin', 'staffProv'],
    icon: 'tab'
  },
  active: false,
  children: [
    ...categoriesRouter,
    ...newsChannelRouter
  ]
}

export default configurationMenuRouter
