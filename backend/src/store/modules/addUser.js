import { getRegion, getKecamatan, getKelurahan, addUser } from '../../api/user';
import { Message } from 'element-ui';
const state = {
  user: [
    {
      username: '',
      nama: '',
      email: '',
      password: '',
      telepon: '',
      alamat: '',
      kota: '',
      kecamatan: '',
      kelurahan: '',
      rw: '',
      rt: '',
      peran: '',
      twitter: '',
      facebook: '',
      instagram: '',
      photo: ''
    }
  ],
  areas: [],
  kecamatan: [],
  kelurahan: []
};

const mutations = {
  ADD_USER: (state, payload) => {
    state.user.push(payload)
  },
  AREAS: (state, payload) => {
    state.areas = payload
  },
  KECAMATAN: (state, payload) => {
    state.kecamatan = payload
  },
  KELURAHAN: (state, payload) => {
    state.kelurahan = payload
  }
}
const actions = {
  pilihKota({ commit }) {
    return new Promise((resolve, rejects) => {
      getRegion()
        .then(response => {
          const { data } = response
          commit('AREAS', data.items)
          resolve()
        })
        .catch(error => {
          error
          rejects()
        })
    })
  },
  pilihKecamatan: async({ commit }, payload) => {
    return new Promise((resolve, rejects) => {
      getKecamatan(payload)
        .then(response => {
          const { data } = response
          commit('KECAMATAN', data.items)
          resolve()
        })
        .catch(error => {
          error
          rejects('failed')
        })
    })
  },
  pilihKelurahan: async({ commit }, payload) => {
    return new Promise((resolve, rejects) => {
      getKelurahan(payload)
        .then(response => {
          const { data } = response
          commit('KELURAHAN', data.items)
          resolve()
        })
        .catch(error => {
          error
          rejects('failed')
        })
    })
  },
  tambahUser: async({ commit }, payload) => {
    return new Promise((resolve, rejects) => {
      addUser(payload)
        .then(() => {
          commit('ADD_USER', payload);
          resolve();
        })
        .catch(error => {
          let usernameError = error.response.data.data.username;
          let emailError = error.response.data.data.email;
          if (!emailError) {
            Message({
              message: usernameError[0],
              type: 'error',
              duration: 5 * 1000
            });
          } else if (!usernameError) {
            Message({
              message: emailError[0],
              type: 'error',
              duration: 5 * 1000
            });
          } else {
            Message({
              message: 'Nama pengguna dan alamat email sudah digunakan',
              type: 'error',
              duration: 5 * 1000
            });
          }
          rejects(error);
        });
    });
  }
}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}
