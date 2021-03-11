import Vue from 'vue'
import axios from 'axios'
import vueAxios from 'vue-axios'

Vue.use(vueAxios, axios)

import router from './router'
import store from './store'

require('../../vendor/js/element.js')

import echarts from 'echarts'
Vue.prototype.$echarts = echarts

let csrf_token = document.head.querySelector('meta[name="csrf-token"]')
csrf_token = csrf_token.getAttribute('content')
window.csrf_token = csrf_token
Vue.axios.defaults.headers.common = {
  'X-CSRF-TOKEN': csrf_token,
  'X-Requested-With': 'XMLHttpRequest'
}
Vue.axios.defaults.baseURL = '/api/admin/'

import App from './App.vue'

Vue.component('App', App)

// 请求拦截
Vue.axios.interceptors.request.use(
  config => {
    let authorization = store.state.authorization
    if (authorization) {
      config.headers['Authorization'] = 'Bearer ' + authorization
    }
    return config
  },
  error => {
    return Promise.reject(error.response.data)
  }
)

// 响应拦截
Vue.axios.interceptors.response.use(
  response => {
    return response.data
  },
  error => {
    if (error.response) {
      let msg = ''
      let toLogin = false
      switch (error.response.status) {
        case 401:
          msg = '401 Unauthorized'
          toLogin = true
          break
        case 403:
          msg = '403 Forbidden'
          break
        case 404:
          msg = '404 Not Found'
          break
        case 405:
          msg = '405 Method Not Allowed'
          break
        case 422:
          msg = '422 Unprocessable Entity'
          break
        case 500:
          msg = '500 Server Error'
          break
      }
      if (msg != '') {
        let message = error.response.data.message
        let errors = error.response.data.errors !== undefined ? error.response.data.errors : null
        if (Object.keys(errors).length > 0) {
          Vue.prototype.$errors(message, errors)
        } else {
          Vue.prototype.$message.error(message)
        }
      }
      if (toLogin) {
        setTimeout(function () {
          router.push({path: '/admin/login'})
        }, 2000)
      }
    }
    return Promise.reject(error.response.data)
  }
)

Vue.component(
  'vue-table',
  () => import('./components/Table.vue')
)

Vue.component(
  'vue-edit',
  () => import('./components/Edit.vue')
)

Vue.component(
  'page-header',
  () => import('./components/PageHeader.vue')
)

Vue.component(
  'page-footer',
  () => import('./components/PageFooter.vue')
)


import checkPermission from './utils/checkPermission'

Vue.directive('permission', {
  bind: function (el, binding, vnode) {
    let permission = binding.value
    if (!checkPermission(permission)) {
      el.style.display = 'none'
    }
  }
})

new Vue({
  el: '#app',
  template: '<App/>',
  router,
  store,
  components: {App}
}).$mount('#app')
