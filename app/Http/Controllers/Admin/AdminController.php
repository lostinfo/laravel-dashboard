<?php
/**
 * Created by PhpStorm.
 * User: wei gao
 * Email:1225039937@qq.com
 * Date: 2019-07-26
 * Time: 12:21
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\ApiController;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends ApiController
{

    public function index(Request $request)
    {
        return $this->response->json(
            Admin::where(function ($query) use ($request) {
                if ($username = $request->get('username')) {
                    $query->where(['username' => $username]);
                }
            })->with(['roles'])->orderBy($this->order_by_column, $this->order_by_direction)->paginate($this->page_size)->toArray()
        );
    }

    public function store(Request $request)
    {
        $id        = $request->get('id');
        $validated = $request->validate([
            'username'        => [
                'required',
                Rule::unique('admins')->where(function ($query) use ($id) {
                    if ($id) {
                        $query->where([
                            ['id', '<>', $id]
                        ]);
                    }
                })
            ],
            'is_supper_admin' => 'required|boolean',
            'roles'           => 'required|array',
        ]);
        if ($id) {
//            测试站不可修改密码
            return $this->response->withUnprocessableEntity('测试站管理员修改功能已屏蔽');
            $admin = Admin::findOrFail($id);
        } else {
            $admin = new Admin();
            $admin->username = $validated['username'];
        }
        if ($password = $request->get('password')) {
//            超级管理员不可修改其他超级管理员的密码
            if ($id && $admin->is_supper_admin && auth('admin')->id() !== $id) {
                return $this->response->withUnprocessableEntity('超级管理员密码只能自己修改');
            }
            $admin->password = Hash::make($password);
        }
        $admin->is_supper_admin = $validated['is_supper_admin'];
        $admin->save();
        $admin->syncRoles($validated['roles']);
        return $this->response->withNotContent();
    }

    public function info(Admin $admin)
    {
        $admin->load('roles');
        $role_ids       = collect($admin->roles)->pluck('id')->all();
        $admin          = $admin->toArray();
        $admin['roles'] = $role_ids;
        return $this->response->json($admin);
    }

    public function destory(Admin $admin)
    {
        return $this->response->withUnprocessableEntity('不可删除');
        // todo can destory
        $admin->delete();
        return $this->response->withNotContent();
    }
}