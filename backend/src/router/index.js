import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

/* Layout */
import Layout from '@/layout'

/* Router Modules */
import dashboardRouter from './modules/dashboard'
import userRouter from './modules/user'
import releaseManagementRouter from './modules/releaseManagement'
import gamificationRouter from './modules/gamification'
import informationMenuRouter from './modules/information-menu'
import aspirationMenuRouter from './modules/aspiration-menu'
import pollingsurveyMenuRouter from './modules/polling-survey-menu'
import notifikasiuserMenuRouter from './modules/notification-user-menu'
import configurationMenuRouter from './modules/configuration-menu'
import broadcastRouter from './modules/broadcast'
import bansosMenuRouter from './modules/bansos-menu'
// import allocationMenuRouter from './modules/allocation-menu'
import listAllocationMenuRouter from './modules/listAllocation-menu'
import downloadAllocationMenuRouter from './modules/download-allocation-menu'

/* Router Modules for Leader */
import aspirationLeaderMenuRouter from './modules/LeaderMenu/aspiration-leader-menu'
import pollingLeaderMenuRouter from './modules/LeaderMenu/polling-leader-menu'
import surveyLeaderMenuRouter from './modules/LeaderMenu/survey-leader-menu'
import newsLeaderMenuRouter from './modules/LeaderMenu/news-leader-menu'
import newsHoaxLeaderMenuRouter from './modules/LeaderMenu/newsHoax-leader-menu'
import qnaLeaderMenuRouter from './modules/LeaderMenu/qna-leader-menu'

/** note: sub-menu only appear when children.length>=1
 *  detail see  https://panjiachen.github.io/vue-element-admin-site/guide/essentials/router-and-nav.html
 **/

/**
* hidden: true                   if `hidden:true` will not show in the sidebar(default is false)
* alwaysShow: true               if set true, will always show the root menu, whatever its child routes length
*                                if not set alwaysShow, only more than one route under the children
*                                it will becomes nested mode, otherwise not show the root menu
* redirect: noredirect           if `redirect:noredirect` will no redirect in the breadcrumb
* name:'router-name'             the name is used by <keep-alive> (must set!!!)
* meta : {
    roles: ['admin','editor']    will control the page roles (you can set multiple roles)
    title: 'title'               the name show in sub-menu and breadcrumb (recommend set)
    icon: 'svg-name'             the icon show in the sidebar
    noCache: true                if true, the page will no be cached(default is false)
    breadcrumb: false            if false, the item will hidden in breadcrumb(default is true)
    affix: true                  if true, the tag will affix in the tags-view
  }
**/

/**
 * constantRoutes
 * a base page that does not have permission requirements
 * all roles can be accessed
 * */
export const constantRoutes = [
  {
    path: '/redirect',
    component: Layout,
    hidden: true,
    active: false,
    children: [
      {
        path: '/redirect/:path*',
        component: () => import('@/views/redirect/index')
      }
    ]
  },
  {
    path: '/login',
    component: () => import('@/views/login/index'),
    active: false,
    hidden: true
  },
  {
    title: 'reset-password',
    path: '/reset-password',
    component: () => import('@/views/resetPassword/index'),
    active: false,
    hidden: true
  },
  {
    path: '/info-penting',
    active: false,
    component: () => import('@/views/public/index'),
    hidden: true
  },
  {
    path: '/auth-redirect',
    component: () => import('@/views/login/authredirect'),
    active: false,
    hidden: true
  },
  {
    title: 'verifikasi-user',
    path: '/confirm',
    component: () => import('@/views/verifikasiUser/index'),
    active: false,
    hidden: true
  },
  {
    path: '/403',
    component: () => import('@/views/errorPage/403'),
    active: false,
    hidden: true
  },
  {
    path: '/404',
    component: () => import('@/views/errorPage/404'),
    active: false,
    hidden: true
  },
  {
    path: '',
    component: Layout,
    redirect: 'profile',
    active: false,
    children: [
      {
        name: 'Profile',
        path: 'profile',
        component: () => import('@/views/profile/index'),
        hidden: true,
        meta: {
          title: 'profile',
          roles: ['admin', 'staffProv', 'staffSaberhoax', 'staffKabkota', 'staffKec', 'staffKel']
        }
      }
    ]
  },
  {
    path: '/edit-profile',
    component: Layout,
    active: false,
    children: [
      {
        name: 'profile-edit',
        path: '',
        component: () => import('@/views/profile/edit'),
        hidden: true,
        meta: {
          title: 'profile',
          roles: ['admin', 'staffProv', 'staffSaberhoax', 'staffKabkota', 'staffKec', 'staffKel']
        }
      }
    ]
  }
]

/**
 * asyncRoutes
 * the routes that need to be dynamically loaded based on user roles
 */
export const asyncRoutes = [
  // title
  {
    name: 'BANTUAN SOSIAL',
    // add object 'action' to disable click
    action: false,
    path: 'no-route-title-bansos',
    component: Layout,
    redirect: 'noredirect',
    meta: {
      title: 'BANTUAN SOSIAL',
      roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel']
    },
    active: false
  },
  bansosMenuRouter,
  // route allocationMenuRouter comment for a while
  // allocationMenuRouter,

  // add menu download verval for kabkota
  {
    name: 'allocation-menu',
    path: 'allocation-menu',
    component: Layout,
    redirect: 'noredirect',
    meta: {
      title: 'allocation-menu',
      roles: ['admin', 'staffKabkota'],
      icon: 'example'
    },
    active: false,
    children: [
      {
        name: 'beneficiaries-download-verval',
        path: '/beneficiaries/download-verval',
        component: () => import('@/views/bansos/download'),
        hidden: false,
        meta: {
          title: 'bansos-download-verval',
          roles: ['staffKabkota']
        }
      }
    ]
  },
  listAllocationMenuRouter,
  downloadAllocationMenuRouter,
  // title
  {
    name: 'KELOLA SAPAWARGA',
    // add object 'action' to disable click & path must be unique
    action: false,
    path: 'no-route-title-sapawarga',
    component: Layout,
    redirect: 'noredirect',
    meta: {
      title: 'KELOLA SAPAWARGA',
      roles: ['admin', 'staffProv', 'staffKabkota', 'staffKec', 'staffKel']
    },
    active: false
  },
  dashboardRouter,
  informationMenuRouter,
  pollingsurveyMenuRouter,
  aspirationMenuRouter,
  notifikasiuserMenuRouter,
  broadcastRouter,
  userRouter,
  configurationMenuRouter,
  releaseManagementRouter,
  gamificationRouter,
  { path: '*', redirect: '/404', active: false, hidden: true }
]

export const leaderRoutes = [
  dashboardRouter,
  qnaLeaderMenuRouter,
  aspirationLeaderMenuRouter,
  pollingLeaderMenuRouter,
  surveyLeaderMenuRouter,
  newsLeaderMenuRouter,
  newsHoaxLeaderMenuRouter,
  { path: '*', redirect: '/404', active: false, hidden: true }
]

const createRouter = () =>
  new Router({
    // mode: 'history', // require service support
    scrollBehavior: () => ({ y: 0 }),
    routes: constantRoutes
  })

const router = createRouter()

// Detail see: https://github.com/vuejs/vue-router/issues/1234#issuecomment-357941465
export function resetRouter() {
  const newRouter = createRouter()
  router.matcher = newRouter.matcher // reset router
}

router.beforeEach((to, from, next) => {
  const nearestWithTitle = to.matched.slice().reverse().find(r => r.path && r.path)

  if (nearestWithTitle !== undefined) {
    const taged = nearestWithTitle.path.split('/')
    // Remove any stale meta tags from the document using the key attribute we set below.
    Array.from(document.querySelectorAll('[data-vue-router-controlled]')).map(el => el.parentNode.removeChild(el))

    // Turn the meta tag definitions into actual elements in the head.
    if ((taged[1] === 'reset-password') || (taged[1] === 'confirm')) {
      // If a route with a title was found, set the document (page) title to that value.
      if (nearestWithTitle) document.title = taged[1]
    } else {
      document.title = 'sapawarga-administrator'
    }
  }
  next()
})

export default router
