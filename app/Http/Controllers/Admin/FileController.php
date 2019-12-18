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

    public function _135editor($id, Request $request)
    {
        $sources = $request->get('sources');
        $client  = new Client();
        $files   = [];
        foreach ($sources as $i => &$source) {
            $source = trim($source);
            $res    = $client->get(trim($source));
            if ($res->getStatusCode() == 200) {
                $content_type = $res->getHeader('content-type')[0];
                $extension    = explode('/', $content_type)[1];
                if ($content_type == 'image/x-icon') $extension = 'ico';
                $content   = $res->getBody()->getContents();
                $file_path = "public/135editor/{$id}/{$i}.{$extension}";
                Storage::put($file_path, $content);
                array_push($files, [
                    'from' => $source,
                    'to'   => asset(Storage::url($file_path))
                ]);
            }
        }
        return $this->response->json($files);
    }

    public function wechat($id, Request $request)
    {
        $sources = $request->get('sources');
        $client  = new Client();
        $files   = [];
        foreach ($sources as $i => &$source) {
            $source = trim($source);
            $res    = $client->get(trim($source), [
                "headers" => [
                    "Origin"     => " https://mp.weixin.qq.com",
                    "Referer"    => "https://mp.weixin.qq.com/s/{$id}",
                    "User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.79 Safari/537.36"
                ]
            ]);
            if ($res->getStatusCode() == 200) {
                $content_type = $res->getHeader('content-type')[0];
                $extension    = explode('/', $content_type)[1];
                if ($content_type == 'image/x-icon') $extension = 'ico';
                $content   = $res->getBody()->getContents();
                $file_path = "public/wechat/{$id}/{$i}.{$extension}";
                Storage::put($file_path, $content);
                array_push($files, [
                    'from' => $source,
                    'to'   => asset(Storage::url($file_path))
                ]);
            }
        }
        return $this->response->json($files);
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
