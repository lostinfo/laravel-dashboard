<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Support\Response;
use Closure;

class CheckAdminIsSupper
{
    /**
     * 验证 admin 是否超级管理
     *
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Admin::where(['id' => auth('admin')->id(), 'is_supper_admin' => true])->exists()) {
            return (new Response(\response()))->withForbidden('User does not have the right permissions.');
        }
        return $next($request);
    }
}
