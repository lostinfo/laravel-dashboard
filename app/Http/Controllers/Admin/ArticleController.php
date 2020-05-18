<?php
/**
 * Created by PhpStorm.
 * User: wei gao
 * Email:1225039937@qq.com
 * Date: 2019-12-11
 * Time: 9:35
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\ApiController;
use App\Http\Requests\Admin\ArticleStoreRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends ApiController
{
    public function index(Request $request)
    {
        return $this->response->json(
            Article::select(['id', 'title', 'created_at'])
            ->where(function ($query) use ($request) {

            })->orderBy($this->order_by_column, $this->order_by_direction)->paginate($this->page_size)->toArray()
        );
    }

    public function store(ArticleStoreRequest $request)
    {
        $validated = $request->validated();

        $validated = $this->transferContent($validated);

        if ($id = $request->get('id')) {
            $article = Article::findOrFail($id);
        } else {
            $article = new Article();
        }
        $article->fill($validated);
        $article->save();
        return $this->response->withNotContent();
    }

    public function info(Article $article)
    {
        return $this->response->json($article->toArray());
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return $this->response->withNotContent();
    }

    protected function transferContent($validated)
    {
        // 防盗链资源转换
        $content       = $validated['content'];
        $markdown      = $validated['markdown'];
        $hosts         = [
            "image2\.135editor\.com",
            "mmbiz\.qpic\.cn",
            "mmbiz\.qlogo\.cn",
            "newcdn\.96weixin\.com",
        ];
        $transfer_urls = [];
        foreach ($hosts as $host) {
            preg_match_all("/[^data-]src=\"(http[s]{0,1}:\/\/{$host}[-A-Za-z0-9\+\&\@\#\/\%\?=~_|!:,.;\s]+)\"|url\([&quot;|\"]*(http[s]{0,1}:\/\/{$host}[-A-Za-z0-9\+\&\@\#\/\%\?=~_|!:,.;\s]+)[&quot;|\"]*\)/m", $content, $matchs);
            foreach ($matchs[1] as $src) {
                $src = trim($src);
                if (!empty($src) && !in_array($src, $transfer_urls)) {
                    array_push($transfer_urls, $src);
                }
            }
            foreach ($matchs[2] as $src) {
                $src = trim($src);
                $src = str_replace("&quot;", "", $src);
                if (!empty($src) && !in_array($src, $transfer_urls)) {
                    array_push($transfer_urls, $src);
                }
            }
        }

        $client = new \GuzzleHttp\Client();
        foreach ($transfer_urls as $transfer_url) {
            $res = $client->get($transfer_url);
            if ($res->getStatusCode() == 200) {
                $content_type = $res->getHeader('content-type')[0];
                $extension    = explode('/', $content_type)[1];
                if ($content_type == 'image/x-icon') $extension = 'ico';
                $file_content = $res->getBody()->getContents();
                $file_name    = \Illuminate\Support\Str::uuid();
                $file_path    = "public/article/{$file_name}.{$extension}";
                Storage::put($file_path, $file_content);
                $src      = config('app.url') . Storage::url($file_path);
                $content  = str_replace($transfer_url, $src, $content);
                $markdown = str_replace($transfer_url, $src, $markdown);
            }
        }
        $validated['content']  = $content;
        $validated['markdown'] = $markdown;
        return $validated;
    }
}
