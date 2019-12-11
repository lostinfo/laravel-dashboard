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

class ArticleController extends ApiController
{
    public function index(Request $request)
    {
        return $this->response->json(
            Article::where(function ($query) use ($request) {

            })->orderBy($this->order_by_column, $this->order_by_direction)->paginate($this->page_size)->toArray()
        );
    }

    public function store(ArticleStoreRequest $request)
    {
        $validated = $request->validated();
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
}