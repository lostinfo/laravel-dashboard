<?php

return [
    [
        'group_name' => '系统',
        'menus'      => [
            [
                'path'     => '/admin/index',
                'name'     => '主页',
                'icon'     => 'fa fa-home',
                'unfolded' => false
            ],
            [
                'path'     => '/admin/articles',
                'name'     => '文章管理',
                'icon'     => 'fa fa-file-text',
                'unfolded' => false
            ],
            [
                'path'     => '/admin/users',
                'name'     => '用户管理',
                'icon'     => 'fa fa-users',
                'unfolded' => false
            ],
        ]
    ],
    [
        'group_name' => '设置',
        'pages'      => [
            '/admin/role/:id',
            '/admin/admin/:id',
            '/admin/swiper/:id',
        ],
        'menus'      => [
            [
                'name'         => '权限管理',
                'icon'         => 'fa fa-shield',
                'unfolded'     => true,
                'supper_admin' => true,
                'children'     => [
                    [
                        'path' => '/admin/roles',
                        'name' => '角色列表',
                    ],
                    [
                        'path' => '/admin/permissions',
                        'name' => '权限列表',
                    ],
                    [
                        'path' => '/admin/admins',
                        'name' => '管理员列表',
                    ],
                ]
            ],
        ]
    ],
];
