export default [
  {
    path: '/admin/404',
    name: 'Alias404',
    component: () => import('./Alias404.vue'),
    meta: {title: '404'}
  },
  {
    path: '/admin/me',
    name: 'Me',
    component: () => import('./Me.vue'),
    meta: {title: '个人中心'}
  },
]
