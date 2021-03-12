export default [
    {
        path: '/admin/articles',
        name: 'Articles',
        component: () => import('./Articles.vue'),
        meta: {title: '文章管理'}
    },
    {
        path: '/admin/article',
        name: 'Article',
        component: () => import('./Article.vue'),
        meta: {title: '新增文章'}
    },
    {
        path: '/admin/article/:id',
        name: 'Article',
        component: () => import('./Article.vue'),
        meta: {title: '修改文章'}
    },
]
