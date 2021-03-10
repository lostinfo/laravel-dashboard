<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class FileController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function article(Request $request)
    {
        return $this->uploadImage($request, 'article');
    }

    public function default(Request $request)
    {
        return $this->uploadImage($request, 'default');
    }

    protected function uploadImage(Request $request, $dir)
    {
        $request->validate([
            'file' => 'file|image'
        ]);
        $path         = $request->file('file')->store('/public/' . $dir);
        $url          = Storage::url($path);
        $absolute_url = asset(Storage::url($path));

        return $this->response->json([
            'name'         => Arr::last(explode('/', $path)),
            'path'         => $path,
            'url'          => $url,
            'absolute_url' => $absolute_url,
        ]);
    }
}
