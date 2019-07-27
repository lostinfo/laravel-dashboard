export default[
  {
    path: '/admin/index',
    name: '主页',
    icon: 'fa fa-home',
    unfolded: false
  },
  {
    path: '/admin/users',
    name: '用户管理',
    icon: 'fa fa-users',
    unfolded: false
  },
  {
    name: '权限管理',
    icon: 'fa fa-shield',
    unfolded: true,
    children: [
      {
        path: '/admin/roles',
        name: '角色列表',
      },
      {
        path: '/admin/permissions',
        name: '权限列表',
      },
      {
        path: '/admin/admins',
        name: '管理员列表',
      },
    ]
  },

]