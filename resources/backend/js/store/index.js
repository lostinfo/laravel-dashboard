import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    admin: null,
    authorization: localStorage.getItem('admin_authorization')
  },
  mutations: {
    setAdmin (state, admin) {
      state.admin = admin
    },
    removeAdmin (state) {
      state.admin = null
    },
    setAuthorization (state, authorization) {
      localStorage.setItem('admin_authorization', authorization)
      state.authorization = authorization
    },
    removeAuthorization (state) {
      localStorage.removeItem('admin_authorization')
      state.authorization = null
    }
  }
})

export default store