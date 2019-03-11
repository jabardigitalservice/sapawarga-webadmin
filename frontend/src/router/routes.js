export const routes = [
  {
    path: '/',
    redirect: '/home'
  },
  {
    path: '/login',
    component: () => import('@/pages/login/Login'),
    name: 'login',
    meta: { requiresLogin: false, title: 'Login' }
  },
  {
    path: '/register',
    component: () => import('@/pages/register/Register'),
    name: 'register',
    meta: { requiresLogin: false, title: 'Register' }
  },
  {
    path: '/home',
    component: () => import('@/pages/Home'),
    meta: { requiresLogin: false, title: 'Home' }
  },
  {
    path: '/articles',
    component: () => import('@/pages/articles/Index'),
    meta: { requiresLogin: true, title: 'Articles' }
  },
  {
    path: '*',
    component: () => import('@/pages/404'),
    meta: { requiresLogin: false, title: 'Page Not Found' }
  }
]
