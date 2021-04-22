import Layout from '@/layout';

const errorRoutes = {
  path: '/error',
  component: Layout,
  redirect: 'noredirect',
  name: 'ErrorPages',
  meta: {
    title: 'routes.page404',
    icon: '404',
  },
  hidden: true,
  children: [
    {
      path: '404',
      component: () => import('@/views/ErrorPage/Page404'),
      name: 'Page404',
      meta: { title: 'routes.page404' },
    },
  ],
};

export default errorRoutes;
