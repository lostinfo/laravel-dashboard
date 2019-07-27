export default [
  {
    path: '/admin/users',
    name: '用户列表',
    component: () => import('./Users.vue')
  },
  {
    path: '/admin/user/:id',
    name: '用户详情',
    component: () => import('./User.vue')
  },
]