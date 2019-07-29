<?php
/**
 * Created by PhpStorm.
 * User: wei gao
 * Email:1225039937@qq.com
 * Date: 2019-07-29
 * Time: 11:39
 */

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