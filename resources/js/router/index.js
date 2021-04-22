import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Layout from '../layout';

import adminRoutes from './modules/admin';
import userRoutes from './modules/user';
import errorRouter from './modules/ErrorPage';

export const constantRoutes = [
  {
    path: '/redirect',
    component: Layout,
    redirect: { name: 'redirect' },
    hidden: true,
    children: [
      {
        path: '/redirect/:path*',
        component: () => import('@/views/Redirect/index'),
        name: 'redirect',
        roles: ['admin'],
      },
      {
        path: '/dashboard/profile',
        component: () => import('@/views/Profile/index'),
        name: 'Profile',
        meta: {
          title: 'profile.title',
        },
        hidden: true,
      },
    ],
  },
  {
    path: '/login',
    component: () => import('@/views/Login/index'),
    name: 'Login',
    meta: {
      title: 'routes.login',
    },
    hidden: true,
  },
  {
    path: '/',
    name: 'Dashboard',
    redirect: '/dashboard',
    meta: {
      title: 'routes.dashboard',
      icon: 'icofont-dashboard-web',
      permissions: ['view menu administrator'],
    },
  },
  {
    path: '/dashboard',
    redirect: 'dashboard/index',
    component: Layout,
    hidden: true,
    children: [
      {
        path: 'index',
        alias: '/dashboard',
        component: () => import('@/views/Dashboard/index'),
        meta: {
          title: 'routes.dashboard',
          icon: 'dashboard',
          permissions: ['view menu user'],
        },
      },
    ],
  },
  {
    path: '/404',
    redirect: { name: 'Page404' },
    component: () => import('@/views/ErrorPage/Page404'),
    hidden: true,
  },
];

export const asyncRoutes = [
  adminRoutes,
  userRoutes,
  errorRouter,
  {
    path: '*',
    redirect: { name: 'Page404' },
    hidden: true,
  },
];

const createRouter = () => new VueRouter({
  scrollBehavior: () => ({ y: 0 }),
  base: process.env.MIX_LARAVUE_PATH,
  routes: constantRoutes,
});

const router = createRouter();

export function resetRouter() {
  const newRouter = createRouter();
  router.matcher = newRouter.matcher; // Reset router
}

export default router;
