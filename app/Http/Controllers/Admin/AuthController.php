<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class AuthController extends ApiController
{
    public function login(Request $request)
    {
        $input = $request->input();
        if($token = auth('admin')->attempt(['username' => $input['username'], 'password' => $input['password']])){
            $admin = auth('admin')->user();
            $admin = $admin->toArray();
            return $this->response->json([
                'admin' => $admin,
                'authorization' => $token
            ]);
        }
        return $this->response->withUnprocessableEntity('账号或者密码不正确');
    }

    public function check()
    {
        if(auth('admin')->check()){
            return $this->response->json([
                'status' => true,
                'admin' => auth('admin')->user()->toArray()
            ]);
        }
        return $this->response->json(['status' => false]);
    }

    public function logout()
    {
        auth('admin')->logout();
        return $this->response->withNotContent();
    }
}