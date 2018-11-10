<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Helpers\FilterHelper;
use Illuminate\Http\Request;

/**
 * Class ArticleController
 *
 * @package App\Http\Controllers
 */
class ArticleController extends Controller
{

    /**
     * Get all articles
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showAllArticles()
    {
        // TODO: paging, limit, sorting
        if (!empty($filters = FilterHelper::prepareFilters())) {
            if (($articles = Article::where(array_values($filters))->get()) && count($articles)) {
                return response()->json($articles);
            }
        } else {
            if ($articles = Article::all()) {
                return response()->json($articles);
            }
        }

        return response('No articles found', 404);
    }

    /**
     * Get only one article
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showOneArticle($id)
    {
        if ($article = Article::find($id)) {
            return response()->json($article);
        }

        return response('Article with id ' . $id . ' not found', 404);
    }

    /**
     * Create an article
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $Article = Article::create($request->all());

        return response()->json($Article, 201);
    }

    /**
     * Update an article
     *
     * @param         $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $Article = Article::findOrFail($id);
        $Article->update($request->json()->all());

        return response()->json($Article, 200);
    }

    /**
     * Delete an article
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function delete($id)
    {
        if ($article = Article::find($id)) {
            if ($article->delete()) {
                return response('Article with id ' . $id . ' deleted successfully', 200);
            }
        }

        return response('Article with id ' . $id . ' not found', 404);
    }

}
