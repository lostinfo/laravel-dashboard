export default [
  {
    path: '/admin/users',
    name: 'Users',
    component: () => import('./Users.vue'),
    meta: {title: '用户列表'}
  },
  {
    path: '/admin/user/:id',
    name: 'User',
    component: () => import('./User.vue'),
    meta: {title: '用户详情'}
  },
]
