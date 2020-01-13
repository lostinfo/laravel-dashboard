<?php
/**
 * Created by PhpStorm.
 * User: wei gao
 * Email:1225039937@qq.com
 * Date: 2019-04-02
 * Time: 10:22
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\ApiController;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function article(Request $request)
    {
        return $this->upload_image($request, 'article');
    }

    protected function upload_image(Request $request, $dir)
    {
        $request->validate([
            'file' => 'file|image'
        ]);
        $path         = $request->file('file')->store('/public/' . $dir);
        $url          = Storage::url($path);
        $absolute_url = asset(Storage::url($path));

        return $this->response->json([
            'name'         => array_last(explode('/', $path)),
            'path'         => $path,
            'url'          => $url,
            'absolute_url' => $absolute_url,
        ]);
    }
}
