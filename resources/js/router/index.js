import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Layout from '../layout';

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
      },
      {
        path: '/dashboard/profile',
        component: () => import('@/views/Profile/index'),
        name: 'Profile',
        meta: {
          title: 'routes.profile',
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
          icon: 'icofont-dashboard-web',
        },
      },
    ],
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
          icon: 'icofont-dashboard-webd',
        },
      },
    ],
  },
  {
    path: '/manager-user',
    redirect: 'manager-user/index',
    component: Layout,
    children: [
      {
        path: 'index',
        component: () => import('@/views/ManagerUser/index'),
        meta: {
          title: 'routes.manager-user',
          icon: 'icofont-dashboard-web',
        },
      },
    ],
  },
  {
    path: '/manager-course',
    redirect: 'manager-course/index',
    component: Layout,
    children: [
      {
        path: 'index',
        component: () => import('@/views/ManagerCourse/index'),
        meta: {
          title: 'routes.manager-course',
          icon: 'icofont-dashboard-web',
        },
      },
    ],
  },
  {
    path: '/manager-class',
    redirect: 'manager-class/index',
    component: Layout,
    children: [
      {
        path: 'index',
        component: () => import('@/views/ManagerClass/index'),
        meta: {
          title: 'routes.manager-class',
          icon: 'icofont-dashboard-web',
        },
      },
    ],
  },
  {
    path: '/teacher-scheduled',
    redirect: 'teacher-scheduled/index',
    component: Layout,
    children: [
      {
        path: 'index',
        component: () => import('@/views/TeacherScheduled/index'),
        meta: {
          title: 'routes.teacher-scheduled',
          icon: 'icofont-dashboard-web',
        },
      },
    ],
  },
  {
    path: '/manager-quiz',
    redirect: 'manager-quizz/index',
    component: Layout,
    children: [
      {
        path: 'index',
        component: () => import('@/views/ManagerQuiz/index'),
        meta: {
          title: 'routes.manager-quiz',
          icon: 'icofont-dashboard-web',
        },
      },
    ],
  },
  {
    path: '/manager-test',
    redirect: 'manager-test/index',
    component: Layout,
    children: [
      {
        path: 'index',
        component: () => import('@/views/ManagerTest/index'),
        meta: {
          title: 'routes.manager-test',
          icon: 'icofont-dashboard-web',
        },
      },
    ],
  },
  {
    path: '/view-result',
    redirect: 'view-result/index',
    component: Layout,
    children: [
      {
        path: 'index',
        component: () => import('@/views/ViewResult/index'),
        meta: {
          title: 'routes.view-result',
          icon: 'icofont-dashboard-web',
        },
      },
    ],
  },
  {
    path: '/choose-class',
    redirect: 'choose-class/index',
    hidden: true,
    component: Layout,
    children: [
      {
        path: 'index',
        component: () => import('@/views/ChooseClass/index'),
        meta: {
          title: 'routes.choose-class',
          icon: 'icofont-dashboard-web',
        },
      },
    ],
  },
  {
    path: '/choose-test',
    redirect: 'choose-test/index',
    hidden: true,
    component: Layout,
    children: [
      {
        path: 'index',
        component: () => import('@/views/ChooseTest/index'),
        meta: {
          title: 'routes.choose-test',
          icon: 'icofont-dashboard-web',
        },
      },
    ],
  },
  {
    path: '/do-test',
    redirect: 'do-test/index',
    hidden: true,
    component: Layout,
    children: [
      {
        path: 'index',
        component: () => import('@/views/DoTest/index'),
        meta: {
          title: 'routes.do-test',
          icon: 'icofont-dashboard-web',
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
