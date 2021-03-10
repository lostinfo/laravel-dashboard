<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Role;

class RoleController extends ApiController
{

    protected $guard_name = 'admin';

    public function __construct()
    {
        parent::__construct();
    }

    public function options(Request $request)
    {
        return $this->response->json(
            Role::where(function ($query) use ($request) {
                if ($name = $request->get('name')) {
                    $query->where(['name' => $name]);
                }
            })->where(['guard_name' => $this->guard_name])->select(['id', 'name'])->get()->toArray()
        );
    }

    public function index(Request $request)
    {
        return $this->response->json(
            Role::withCount('permissions')->orderBy($this->order_by_column, $this->order_by_direction)->paginate($this->page_size)->toArray()
        );
    }

    public function store(Request $request)
    {
        $id        = $request->get('id');
        $validated = $request->validate([
            'name'        => [
                'required',
                Rule::unique('roles')->where(function ($query) use ($id) {
                    $query->where(['guard_name' => $this->guard_name]);
                    if ($id) {
                        $query->where([
                            ['id', '<>', $id]
                        ]);
                    }
                })
            ],
            'permissions' => 'required|array',
            'menus'       => 'required|array',
        ]);
        if ($id) {
            $role        = Role::findById($id);
            $role->name  = $validated['name'];
            $role->menus = $validated['menus'];
        } else {
            $role = Role::create([
                'name'       => $validated['name'],
                'guard_name' => $this->guard_name,
                'menus'      => $validated['menus'],
            ]);
        }
        $role->syncPermissions($validated['permissions']);
        $role->save();
        return $this->response->withNotContent();
    }

    public function info(Role $role)
    {
        $role->load('permissions');
        $permission_ids      = collect($role->permissions)->pluck('id')->all();
        $role                = $role->toArray();
        $role['permissions'] = $permission_ids;
        return $this->response->json($role);
    }

    public function destory(Role $role)
    {
        return $this->response->withUnprocessableEntity('不可删除');
        // todo can destory
        $role->delete();
        return $this->response->withNotContent();
    }

    public function menuOptions()
    {
        return $this->response->json(config('menu'));
    }
}
