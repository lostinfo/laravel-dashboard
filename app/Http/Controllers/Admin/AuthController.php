<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\ApiController;
use App\Models\Admin;
use Illuminate\Http\Request;

class AuthController extends ApiController
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if ($token = auth('admin')->attempt([
            'username' => $validated['username'],
            'password' => $validated['password'],
            'active'   => true,
        ])) {
            return $this->response->json([
                'admin'         => $this->responseAdmin(auth('admin')->user()),
                'authorization' => $token
            ]);
        }
        return $this->response->withUnprocessableEntity('账号密码不匹配或账号未激活');
    }

    public function check()
    {
        if (auth('admin')->check()) {
            return $this->response->json([
                'status' => true,
                'admin'  => $this->responseAdmin(auth('admin')->user())
            ]);
        }
        return $this->response->json(['status' => false]);
    }

    public function logout()
    {
        auth('admin')->logout();
        return $this->response->withNotContent();
    }

    /**
     * @param Admin $admin
     * @return array
     */
    protected function responseAdmin(Admin $admin)
    {
        $admin->load([
            'roles',
        ]);
        if (!$admin->is_supper_admin) {
            $admin_paths = collect($admin->roles)->pluck('menus')->collapse()->all();
            $menus = $this->getMenusByPaths($admin_paths);
        } else {
            $menus = config('menu');
        }
        return [
            'username'        => $admin->username,
            'is_supper_admin' => $admin->is_supper_admin,
            'roles'           => $admin->roles->toArray(),
            'menus'           => $menus,
            'created_at'      => $admin->created_at->format('Y-m-d'),
        ];
    }

    protected function getMenusByPaths(array $paths)
    {
        $menus = config('menu');
        foreach ($menus as $menu_group_index => $menu_group) {
            foreach ($menu_group['menus'] as $menu_index => $menu) {
                if ($menu['unfolded']) {
                    foreach ($menu['children'] as $menu_item_index => $menu_item) {
                        if (!in_array($menu_item['path'], $paths)) {
                            unset($menus[$menu_group_index]['menus'][$menu_index]['children'][$menu_item_index]);
                        }
                    }
                    if (count($menus[$menu_group_index]['menus'][$menu_index]['children']) < 1) {
                        unset($menus[$menu_group_index]['menus'][$menu_index]);
                    }
                } else {
                    if (!in_array($menu['path'], $paths)) {
                        unset($menus[$menu_group_index]['menus'][$menu_index]);
                    }
                }
            }
            if (count($menus[$menu_group_index]['menus']) < 1) {
                unset($menus[$menu_group_index]);
            }
        }
        return array_values($menus);
    }
}