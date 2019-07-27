export default [
  {
    path: '/admin/roles',
    name: '角色列表',
    component: () => import('./Roles.vue')
  },
  {
    path: '/admin/role',
    name: '新增角色',
    component: () => import('./Role.vue')
  },
  {
    path: '/admin/role/:id',
    name: '修改角色',
    component: () => import('./Role.vue')
  },
  {
    path: '/admin/permissions',
    name: '权限列表',
    component: () => import('./Permissions.vue')
  },
  {
    path: '/admin/admins',
    name: '管理员列表',
    component: () => import('./Admins.vue')
  },
  {
    path: '/admin/admin',
    name: '新增管理员',
    component: () => import('./Admin.vue')
  },
  {
    path: '/admin/admin/:id',
    name: '修改管理员',
    component: () => import('./Admin.vue')
  },
]