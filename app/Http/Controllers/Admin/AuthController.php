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
                'admin'         => auth('admin')->user(),
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
        return [
            'username'        => $admin->username,
            'is_supper_admin' => $admin->is_supper_admin,
            'roles'           => $admin->roles->toArray(),
            'created_at'      => $admin->created_at->format('Y-m-d'),
        ];
    }
}