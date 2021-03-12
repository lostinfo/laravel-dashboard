export default [
    {
        path: '/admin/roles',
        name: 'Roles',
        component: () => import('./Roles.vue'),
        meta: {title: '角色列表'}
    },
    {
        path: '/admin/role',
        name: 'Role',
        component: () => import('./Role.vue'),
        meta: {title: '新增角色'}
    },
    {
        path: '/admin/role/:id',
        name: 'Role',
        component: () => import('./Role.vue'),
        meta: {title: '修改角色'}
    },
    {
        path: '/admin/permissions',
        name: 'Permissions',
        component: () => import('./Permissions.vue'),
        meta: {title: '权限列表'}
    },
    {
        path: '/admin/admins',
        name: 'Admins',
        component: () => import('./Admins.vue'),
        meta: {title: '管理员列表'}
    },
    {
        path: '/admin/admin',
        name: 'Admin',
        component: () => import('./Admin.vue'),
        meta: {title: '新增管理员'}
    },
    {
        path: '/admin/admin/:id',
        name: 'Admin',
        component: () => import('./Admin.vue'),
        meta: {title: '修改管理员'}
    },
]
