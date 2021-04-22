import router from './router';
import store from './store';
import { MakeToast } from '@/utils/toast_message';
import { isLogged } from '@/utils/auth';
import getPageTitle from '@/utils/get-page-title';

const whiteList = ['/login'];

router.beforeEach(async(to, from, next) => {
  document.title = getPageTitle(to.meta.title);

  const isUserLogged = isLogged();

  if (isUserLogged) {
    if (to.path === '/login') {
      next({ path: '/' });
    } else {
      const hasRoles = store.getters.roles && store.getters.roles.length > 0;

      if (hasRoles) {
        next();
      } else {
        try {
          const { roles, permissions } = await store.dispatch('user/getInfo');

          const accessRoutes = await store.dispatch('permission/generateRoutes', { roles, permissions });

          router.addRoutes(accessRoutes);

          next({ ...to, replace: true });
        } catch (err) {
          await store.dispatch('user/resetToken');

          MakeToast({ variant: 'danger', title: 'Login Fail!!', content: 'Fail to Login' });

          next(`/login?redirect=${to.path}`);
        }
      }
    }
  } else {
    if (whiteList.indexOf(to.matched[0] ? to.matched[0].path : '') !== -1) {
      next();
    } else {
      next(`/login?redirect=${to.path}`);
    }
  }
});
