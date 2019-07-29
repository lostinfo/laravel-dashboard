<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Support\Response;
use Closure;

class CheckAdminActive
{
    /**
     * check admin is active
     *
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        // 减少数据库查询压力 使用 2
        // 如果 auth()->user() 只查询一次那就好了
        // auth()->user() 返回了 Model 的单例 如果重复使用 可能会有异常
        // 1. auth('admin')->user()->active
        // 2. Admin::where(['id' => auth('admin')->id(), 'active' => true])->exists()
        if (!Admin::where(['id' => auth('admin')->id(), 'active' => true])->exists()) {
            return (new Response(\response()))->withUnauthorized('账户未激活');
        }
        return $next($request);
    }
}
