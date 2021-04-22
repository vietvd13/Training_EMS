const getters = {
  language: state => state.app.language,
  userId: state => state.user.id,
  email: state => state.user.email,
  name: state => state.user.name,
  permissions: state => state.user.permissions,
  roles: state => state.user.roles,
  token: state => state.user.token,
  avatar: state => state.user.avatar,
  permissionRoutes: state => state.permission.routes,
  addRoutes: state => state.permission.addRoutes,
};

export default getters;
