import index from './index'
import user from './user'
import permission from './permission'

export default [
  {
    path: '/admin',
    redirect: '/admin/index',
    component: () => import('./Root.vue'),
    children: [
      ...index,
      ...user,
      ...permission,
      {
        path: '/admin/404',
        name: '404 Not Found',
        component: () => import('./Alias404.vue')
      }
    ]
  },
  {
    path: '/admin/login',
    component: () => import('./Login.vue')
  },
  {
    path: '*',
    redirect: '/admin/404'
  }
]