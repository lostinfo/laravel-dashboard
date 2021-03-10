<?php

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
            'username' => [
                'required',
                Rule::unique('admins')->where(function ($query) use ($id) {
                    if ($id) {
                        $query->where([
                            ['id', '<>', $id]
                        ]);
                    }
                })
            ],
            'active'   => 'required|boolean',
            'roles'    => 'required|array',
        ]);
        if ($id) {
            // TEST S
//            测试站不可修改密码
            if ($request->get('password')) {
                return $this->response->withUnprocessableEntity('测试站密码修改功能已屏蔽');
            }
            // TEST E
            $admin = Admin::where(['is_supper_admin' => false])->findOrFail($id);
        } else {
            $admin           = new Admin();
            $admin->username = $validated['username'];
        }
        if ($password = $request->get('password')) {
            $admin->password = Hash::make($password);
        }
        $admin->is_supper_admin = false;
        $admin->active          = $validated['active'];
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
