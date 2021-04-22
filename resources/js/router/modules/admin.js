import Layout from '@/layout';

const adminRoutes = {
  path: '/administrator',
  component: Layout,
  name: 'Administrator',
  meta: {
    title: 'routes.administrator',
    icon: 'icofont-crown',
  },
  children: [
    {
      path: 'index',
      component: () => import('@/views/Admin/index'),
      meta: {
        title: 'routes.havepermission',
        icon: 'icofont-check-alt',
        permissions: ['view menu administrator'],
      },

    },
    {
      path: 'index2',
      component: () => import('@/views/Admin/index2'),
      meta: {
        title: 'routes.nothavepermission',
        icon: 'icofont-close-circled',
      },

    },
  ],

};

export default adminRoutes;
