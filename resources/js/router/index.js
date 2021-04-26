import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Layout from '../layout';

import errorRouter from './modules/ErrorPage';

export const constantRoutes = [
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
    path: '/',
    name: 'Dashboard',
    redirect: '/dashboard',
    meta: {
      title: 'routes.dashboard',
      icon: 'icofont-university',
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
          icon: 'icofont-university',
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
          icon: 'icofont-university',
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
  {
    path: '/manage-user',
    redirect: 'manage-user/index',
    component: Layout,
    meta: {
      roles: ['admin'],
    },
    children: [
      {
        path: 'index',
        component: () => import('@/views/ManageUser/index'),
        meta: {
          title: 'routes.manage-user',
          icon: 'icofont-users-social',
        },
      },
    ],
  },
  {
    path: '/manage-course',
    redirect: 'manage-course/index',
    component: Layout,
    meta: {
      roles: ['admin', 'staff'],
    },
    children: [
      {
        path: 'index',
        component: () => import('@/views/ManageCourse/index'),
        meta: {
          title: 'routes.manage-course',
          icon: 'icofont-electron',
        },
      },
    ],
  },
  {
    path: '/manage-class',
    redirect: 'manage-class/index',
    component: Layout,
    meta: {
      roles: ['admin', 'staff'],
    },
    children: [
      {
        path: 'index',
        component: () => import('@/views/ManageClass/index'),
        meta: {
          title: 'routes.manage-class',
          icon: 'icofont-school-bag',
        },
      },
    ],
  },
  {
    path: '/trainer-scheduled',
    redirect: 'trainer-scheduled/index',
    component: Layout,
    meta: {
      roles: ['admin', 'staff'],
    },
    children: [
      {
        path: 'index',
        component: () => import('@/views/TrainerScheduled/index'),
        meta: {
          title: 'routes.trainer-scheduled',
          icon: 'icofont-meeting-add',
        },
      },
    ],
  },
  {
    path: '/manage-quiz',
    redirect: 'manage-quizz/index',
    component: Layout,
    meta: {
      roles: ['admin', 'trainer'],
    },
    children: [
      {
        path: 'index',
        component: () => import('@/views/ManageQuiz/index'),
        meta: {
          title: 'routes.manage-quiz',
          icon: 'icofont-paper',
        },
      },
    ],
  },
  {
    path: '/manage-test',
    redirect: 'manage-test/index',
    component: Layout,
    meta: {
      roles: ['admin', 'trainer'],
    },
    children: [
      {
        path: 'index',
        component: () => import('@/views/ManageTest/index'),
        meta: {
          title: 'routes.manage-test',
          icon: 'icofont-prescription',
        },
      },
    ],
  },
  {
    path: '/view-result',
    redirect: 'view-result/index',
    component: Layout,
    meta: {
      roles: ['admin', 'trainer', 'trainee'],
    },
    children: [
      {
        path: 'index',
        component: () => import('@/views/ViewResult/index'),
        meta: {
          title: 'routes.view-result',
          icon: 'icofont-chart-pie',
        },
      },
    ],
  },
  {
    path: '/choose-class',
    redirect: 'choose-class/index',
    hidden: true,
    component: Layout,
    meta: {
      roles: ['admin', 'trainee'],
    },
    children: [
      {
        path: 'index',
        component: () => import('@/views/ChooseClass/index'),
        meta: {
          title: 'routes.choose-class',
          icon: 'icofont-instrument',
        },
      },
    ],
  },
  {
    path: '/choose-course',
    redirect: 'choose-course/index',
    hidden: true,
    component: Layout,
    meta: {
      roles: ['admin', 'trainee'],
    },
    children: [
      {
        path: 'index',
        component: () => import('@/views/ChooseCourse/index'),
        meta: {
          title: 'routes.choose-course',
          icon: 'icofont-instrument',
        },
      },
    ],
  },
  {
    path: '/choose-test',
    redirect: 'choose-test/index',
    hidden: true,
    component: Layout,
    meta: {
      roles: ['admin', 'trainee'],
    },
    children: [
      {
        path: 'index',
        component: () => import('@/views/ChooseTest/index'),
        meta: {
          title: 'routes.choose-test',
          icon: 'icofont-instrument',
        },
      },
    ],
  },
  {
    path: '/do-test',
    redirect: 'do-test/index',
    hidden: true,
    component: Layout,
    meta: {
      roles: ['admin', 'trainee'],
    },
    children: [
      {
        path: 'index',
        component: () => import('@/views/DoTest/index'),
        meta: {
          title: 'routes.do-test',
          icon: 'icofont-instrument',
        },
      },
    ],
  },
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
