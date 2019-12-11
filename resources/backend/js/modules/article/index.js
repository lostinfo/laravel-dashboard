export default [
  {
    path: '/admin/articles',
    name: '文章管理',
    component: () => import('./Articles.vue')
  },
  {
    path: '/admin/article',
    name: '新增文章',
    component: () => import('./Article.vue')
  },
  {
    path: '/admin/article/:id',
    name: '修改文章',
    component: () => import('./Article.vue')
  },
]