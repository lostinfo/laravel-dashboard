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
