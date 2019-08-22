<?php
/**
 * Created by PhpStorm.
 * User: wei gao
 * Email:1225039937@qq.com
 * Date: 2019-07-25
 * Time: 15:21
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\ApiController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use App\Models\Permission;

class PermissionController extends ApiController
{
    protected $guard_name = 'admin';

    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        return $this->response->json(
            Permission::where(function ($query) use ($request) {
                if ($alias = $request->get('alias')) {
                    $query->where(['alias' => $alias]);
                }
            })->orderBy($this->order_by_column, $this->order_by_direction)->paginate($this->page_size)->toArray()
        );
    }

    public function store(Request $request)
    {
        $validated         = $request->validate([
            'id'    => 'required|exists:permissions',
            'alias' => 'required|string',
        ]);
        $permission        = Permission::findOrFail($validated['id']);
        $permission->alias = $validated['alias'];
        $permission->save();
        return $this->response->withNotContent();
    }

    public function options()
    {
        return $this->response->json(Permission::where(['guard_name' => $this->guard_name])->select(['id', 'name', 'alias'])->get()->groupBy('group_name')->toArray());
    }

    public function refresh(Router $router)
    {
        $permissions = collect($router->getRoutes())->map(function ($route) {
            return collect($route->gatherMiddleware())->map(function ($middleware) {
                $middleware = $middleware instanceof Closure ? 'Closure' : $middleware;
                if (preg_match('/^permission:/', $middleware)) {
                    return ['permission' => explode(':', $middleware)[1]];
                }
                return null;
            })->filter(function ($permission) {
                return !empty($permission);
            })->values();
        })->collapse()->values()->all();
        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission['permission'], $this->guard_name);
        }
        return $this->response->withNotContent();
    }
}