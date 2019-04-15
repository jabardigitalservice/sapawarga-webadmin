import Axios from 'axios';
import getters from '../getters';
import { getRegion, getKecamatan, getKelurahan } from '../../api/user';
import { resolve } from 'url';
import { rejects } from 'assert';

// (state = {
//   // todos: null
// }),
//   (getters = {
//     TODOS: state => {
//       return state.todos;
//     }
//   }),
//   (mutations = {
//     SET_TODO: (state, payload) => {
//       state.todos = payload;
//     },
//     ADD_TODO: (state, payload) => {
//       state.todos.push(payload);
//     }
//   }),
//   (actions = {
//     GET_TODO: async (context, payload) => {
//       let { data } = await Axios.get('http://yourwebsite.com/api/todo');
//       context.commit('SET_TODO', data);
//     },
//     SAVE_TODO: async (context, payload) => {
//       let { data } = await Axios.post('http://yourwebsite.com/api/todo');
//       context.commit('ADD_TODO', payload);
//     }
//   });
const state = {
  user: [
    {
      username: 'maruf',
      nama: 'harsono'
    }
  ],
  areas: [
    {
      id: '',
      name: '',
      parent_id: '',
      depth: ''
    }
  ],
  kecamatan: [
    {
      id: '',
      name: '',
      parent_id: '',
      depth: ''
    }
  ],
  kelurahan: [
    {
      id: '',
      name: '',
      parent_id: '',
      depth: ''
    }
  ]
};

const mutations = {
  ADD_USER: (state, payload) => {
    state.user.push(payload);
  },
  AREAS: (state, payload) => {
    state.areas = payload;
  },
  KECAMATAN: (state, payload) => {
    state.kecamatan = payload;
    console.log('Mutation kecamatan');
  },
  KELURAHAN: (state, payload) => {
    state.kelurahan = payload;
    console.log('Mutation kelurahan');
  }
};
const actions = {
  // tambah({ commit }, payload) {
  //   // let { data } = await Axios.post();
  //   commit('ADD_USER', payload);
  //   console.log('action berhasil dipanggil');
  // },
  pilihKota: async ({ commit }) => {
    return new Promise((resolve, rejects) => {
      getRegion()
        .then(response => {
          const { data } = response;
          commit('AREAS', data.items);
          resolve();
        })
        .catch(error => {
          error;
          rejects();
        });
    });
  },
  pilihKecamatan: async ({ commit }, payload) => {
    return new Promise((resolve, rejects) => {
      getKecamatan(payload)
        .then(response => {
          const { data } = response;
          commit('KECAMATAN', data.items);
          resolve();
        })
        .catch(error => {
          error;
          rejects('failed');
        });
    });
  },
  pilihKelurahan: async ({ commit }, payload) => {
    return new Promise((resolve, rejects) => {
      getKelurahan(payload)
        .then(response => {
          const { data } = response;
          commit('KELURAHAN', data.items);
          resolve();
        })
        .catch(error => {
          error;
          rejects('failed');
        });
    });
  }
};

export default {
  namespaced: true,
  state,
  mutations,
  actions
};
