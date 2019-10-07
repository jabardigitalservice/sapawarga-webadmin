import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

/* Layout */
import Layout from '@/layout'

/* Router Modules */
import userRouter from './modules/user'
import nomorPentingRouter from './modules/nomorPenting'
import broadcastRouter from './modules/broadcast'
import notificationRouter from './modules/notification'
import aspirationRouter from './modules/aspiration'
import pollingRouter from './modules/polling'
import surveyRouter from './modules/survey'
import newsRouter from './modules/news'
import categoriesRouter from './modules/categories'
import videoRouter from './modules/video'
import newsChannelsRouter from './modules/newsChannels'
import releaseManagementRouter from './modules/releaseManagement'
import newsHoaxRouter from './modules/newsHoax'

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
    hidden: true
  },
  {
    path: '/reset-password',
    component: () => import('@/views/resetPassword/index'),
    hidden: true
  },
  {
    path: '/auth-redirect',
    component: () => import('@/views/login/authredirect'),
    hidden: true
  },
  {
    path: '/confirm',
    component: () => import('@/views/verifikasiUser/index'),
    hidden: true
  },
  {
    path: '/404',
    component: () => import('@/views/errorPage/404'),
    hidden: true
  },
  {
    path: '/401',
    component: () => import('@/views/errorPage/401'),
    hidden: true
  },

  // rute dashboard ini di matikan sementara, karena dashboard belum siap.
  {
    path: '',
    component: Layout,
    redirect: 'dashboard',
    children: [
      {
        path: 'dashboard',
        component: () => import('@/views/dashboard/index'),
        name: 'Dashboard',
        meta: {
          title: 'dashboard',
          icon: 'dashboard',
          noCache: true,
          affix: true,
          roles: ['admin', 'staffProv']
        }
      }
    ]
  },

  // dashboard sementara diganti jadi profile.
  // {
  //   path: '',
  //   component: Layout,
  //   redirect: 'profile',
  //   children: [
  //     {
  //       path: 'dashboard',
  //       component: () => import('@/views/profile/index'),
  //       name: 'Dashboard',
  //       meta: {
  //         title: 'profile',
  //         icon: 'dashboard',
  //         noCache: true,
  //         affix: true
  //       }
  //     }
  //   ]
  // },
  {
    path: '/profile',
    component: Layout,
    children: [
      {
        name: 'Profile',
        path: '',
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

  userRouter,
  nomorPentingRouter,
  broadcastRouter,
  notificationRouter,
  aspirationRouter,
  pollingRouter,
  surveyRouter,
  newsRouter,
  newsHoaxRouter,
  categoriesRouter,
  videoRouter,
  newsChannelsRouter,
  releaseManagementRouter,
  { path: '*', redirect: '/404', hidden: true }
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

export default router
