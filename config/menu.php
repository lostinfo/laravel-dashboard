<?php
/**
 * Created by PhpStorm.
 * User => wei gao
 * Email =>1225039937@qq.com
 * Date => 2019-07-30
 * Time => 8 =>57
 */

return [
    [
        'group_name' => '处理中心',
        'menus'      => [
            [
                'path'     => '/admin/index',
                'name'     => '主页',
                'icon'     => 'fa fa-home',
                'unfolded' => false
            ],
        ]
    ],
    [
        'group_name' => '我的工作台',
        'menus'      => [
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
        'menus'      => [
            [
                'name'     => '权限管理',
                'icon'     => 'fa fa-shield',
                'unfolded' => true,
                'supper_admin' => true,
                'children' => [
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