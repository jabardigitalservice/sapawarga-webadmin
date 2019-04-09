import { login, logout, getInfo } from '@/api/user';
import { getToken, setToken, removeToken } from '@/utils/auth';
import router, { resetRouter } from '@/router';

const state = {
  token: getToken(),
  name: '',
  avatar: '',
  introduction: '',
  roles: []
};

const mutations = {
  SET_TOKEN: (state, token) => {
    state.token = token;
  },
  SET_INTRODUCTION: (state, introduction) => {
    state.introduction = introduction;
  },
  SET_NAME: (state, name) => {
    state.name = name;
  },
  SET_AVATAR: (state, avatar) => {
    state.avatar = avatar;
  },
  SET_ROLES: (state, roles) => {
    state.roles = roles;
  }
};

const actions = {
  // user login
  login({ commit }, userInfo) {
    const { username, password } = userInfo;

    return new Promise((resolve, reject) => {
      login({ LoginForm: { username: username.trim(), password: password } })
        .then(response => {
          const { data } = response;
          commit('SET_TOKEN', data.access_token);
          setToken(data.access_token);
          resolve();
        })
        .catch(error => {
          error;
          reject();
        });
    });
  },

  // get user info
  getInfo({ commit, state }) {
    return new Promise((resolve, reject) => {
      getInfo(state.token)
        .then(response => {
          let { data } = response;
          console.log(data.photo_url);

          if (!data) {
            reject('Verification failed, please Login again.');
          }

          const { name, photo_url, introduction } = data;

          console.log(photo_url);

          const roles = ['admin'];

          // roles must be a non-empty array
          if (!roles || roles.length <= 0) {
            reject('getInfo: roles must be a non-null array!');
          }

          commit('SET_ROLES', roles);
          commit('SET_NAME', name);
          if (photo_url == null) {
            commit(
              'SET_AVATAR',
              'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif'
            );
          } else {
            commit('SET_AVATAR', photo_url);
          }

          // commit('SET_INTRODUCTION', introduction);
          data = roles;
          resolve(data);
        })
        .catch(error => {
          reject(error);
        });
    });
  },

  // user logout
  logout({ commit }) {
    return new Promise((resolve, reject) => {
      commit('SET_TOKEN', '');
      commit('SET_ROLES', []);
      removeToken();
      resetRouter();
      resolve();
    });
  },

  // remove token
  resetToken({ commit }) {
    return new Promise(resolve => {
      commit('SET_TOKEN', '');
      commit('SET_ROLES', []);
      removeToken();
      resolve();
    });
  },

  // Dynamically modify permissions
  changeRoles({ commit, dispatch }, role) {
    return new Promise(async resolve => {
      const token = role + '-token';

      commit('SET_TOKEN', token);
      setToken(token);

      const { roles } = await dispatch('getInfo');

      resetRouter();

      // generate accessible routes map based on roles
      const accessRoutes = await dispatch('permission/generateRoutes', roles, {
        root: true
      });

      // dynamically add accessible routes
      router.addRoutes(accessRoutes);

      resolve();
    });
  }
};

export default {
  namespaced: true,
  state,
  mutations,
  actions
};
