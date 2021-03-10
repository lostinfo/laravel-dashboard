import Vue from 'vue'
import Router from 'vue-router'

import routes from '../modules/routes'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  routes: [
    {
      path: '/admin',
      redirect: '/admin/index',
      component: () => import('../modules/Root.vue'),
      children: [
        ...routes,
        {
          path: '/admin/404',
          name: '404 Not Found',
          component: () => import('../modules/Alias404.vue')
        },
        {
          path: '/admin/me',
          name: '个人中心',
          component: () => import('../modules/Me.vue')
        },
      ]
    },
    {
      path: '/admin/login',
      component: () => import('../modules/Login.vue')
    },
    {
      path: '*',
      redirect: '/admin/404'
    }
  ],
})

router.beforeEach((to, from, next) => {
  next()
})
export default router
