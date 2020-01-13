const state = {
  mision: [
    {
      fitur: '',
      jumlah_task: 0,
      deskripsi: ''
    }
  ]
}

const mutations = {
  // dynamically add new rows.
  addMisionRow(state) {
    state.mision.push({
      fitur: '',
      jumlah_task: 0,
      deskripsi: ''
    })
  },
  deleteMisionRow(state, index) {
    // dynamically remove new rows.
    state.mision.splice(index, 1)
  }
}

export default {
  namespaced: true,
  state,
  mutations
}
