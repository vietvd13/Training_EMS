import Layout from '@/layout';

const userRoutes = {
  path: '/user',
  component: Layout,
  name: 'User',
  meta: {
    title: 'User',
    icon: 'icofont-flag-alt-1',
  },
  children: [
    {
      path: 'index',
      component: () => import('@/views/User/index'),
      meta: {
        title: 'routes.user',
        icon: 'icofont-flag-alt-1',
      },
    },
  ],
};

export default userRoutes;
