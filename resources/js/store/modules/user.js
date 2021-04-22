import { postLogin, getInfo, logout } from '@/api/login';
import { isLogged, setLogged, removeToken } from '@/utils/auth';
import { resetRouter } from '@/router';

const state = {
  id: null,
  email: '',
  name: '',
  token: isLogged(),
  permissions: [],
  roles: [],
  avatar: '',
};

const mutations = {
  SET_ID: (state, id) => {
    state.id = id;
  },
  SET_EMAIL: (state, email) => {
    state.email = email;
  },
  SET_NAME: (state, name) => {
    state.name = name;
  },
  SET_TOKEN: (state, token) => {
    state.token = token;
  },
  SET_PERMISSIONS: (state, permissions) => {
    state.permissions = permissions;
  },
  SET_ROLES: (state, roles) => {
    state.roles = roles;
  },
  SET_AVATAR: (state, avatar) => {
    state.avatar = avatar;
  },
};

const actions = {
  // Login
  postLogin({ commit }, userInfo) {
    const { email, password } = userInfo;
    return new Promise((resolve, reject) => {
      postLogin({ email: email.trim(), password: password })
        .then(() => {
          setLogged('1');
          resolve();
        })
        .catch(error => {
          console.log(error);
          reject(error);
        });
    });
  },

  // Get Full Infor User
  getInfo({ commit, state }) {
    return new Promise((resolve, reject) => {
      getInfo()
        .then(res => {
          const { data } = res;

          if (!data) {
            reject('Verification failed, please Login again.');
          }

          const { id, email, name, permissions, roles, token, avatar } = data;

          if (!roles || roles.length < 0) {
            reject('getInfo: roles must be a non-null array!');
          }

          commit('SET_ID', id);
          commit('SET_EMAIL', email);
          commit('SET_NAME', name);
          commit('SET_PERMISSIONS', permissions);
          commit('SET_ROLES', roles);
          commit('SET_TOKEN', token);
          commit('SET_AVATAR', avatar);

          resolve(data);
        })
        .catch(err => {
          reject(err);
        });
    });
  },

  // Logout
  logout({ commit }) {
    return new Promise((resolve, reject) => {
      logout()
        .then(() => {
          commit('SET_TOKEN', '');
          commit('SET_ROLES', []);

          removeToken();
          resetRouter();
          resolve();
        })
        .catch(err => {
          console.log(err);
          reject(err);
        });
    });
  },

  // Remove token
  resetToken({ commit }) {
    return new Promise(resolve => {
      commit('SET_TOKEN', '');
      commit('SET_ROLES', []);
      removeToken();
      resolve();
    });
  },
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
};
