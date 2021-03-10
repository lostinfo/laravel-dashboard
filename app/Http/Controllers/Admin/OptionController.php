<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\ApiController;

class OptionController extends ApiController
{
    public function options($key)
    {
        $method = $key . 'Options';
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        return $this->response->json([]);
    }
}
