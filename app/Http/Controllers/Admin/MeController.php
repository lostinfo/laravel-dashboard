<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MeController extends ApiController
{
    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'old_password' => 'required|min:5',
            'password' => 'required|min:5',
        ]);
        // TEST S
        return $this->response->withUnprocessableEntity('测试站密码修改功能已屏蔽');
        // TEST E
        if (!auth('admin')->validate([
            'id' => auth('admin')->id(),
            'password' => $validated['old_password'],
        ])) {
            return $this->response->withUnprocessableEntity('密码验证失败');
        }
        $admin = auth('admin')->user();
        $admin->password = Hash::make($validated['password']);
        $admin->save();
        return $this->response->withNotContent();
    }
}
