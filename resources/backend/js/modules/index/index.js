export default [
  {
    path: '/admin/index',
    name: 'Index',
    component: () => import('./Index.vue'),
    meta: {title: '主页', affix: true}
  }
]
