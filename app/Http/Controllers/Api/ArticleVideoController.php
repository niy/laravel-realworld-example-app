<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UpdateArticleVideo;
use App\RealWorld\Video\VideoHelperInterface;
use App\Tag;
use App\Article;
use App\RealWorld\Paginate\Paginate;
use App\RealWorld\Filters\ArticleFilter;
use App\Http\Requests\Api\CreateArticle;
use App\Http\Requests\Api\UpdateArticle;
use App\Http\Requests\Api\DeleteArticle;
use App\RealWorld\Transformers\ArticleTransformer;
use App\Video;

class ArticleVideoController extends ApiController
{
    /**
     * ArticleController constructor.
     *
     * @param ArticleTransformer $transformer
     */
    public function __construct(ArticleTransformer $transformer)
    {
        $this->transformer = $transformer;

        $this->middleware('auth.api');
    }

    /**
     * Update the article video given by its slug and return the article if successful.
     *
     * @param UpdateArticleVideo $request
     * @param Article $article
     * @param VideoHelperInterface $videoHelper
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UpdateArticleVideo $request, Article $article, VideoHelperInterface $videoHelper)
    {
        if ($request->hasFile('video')) {
            // upload video to arvan and update article
            $videoHelper->scheduleVideoUpload($article, $request->file('video'));
        }

        return $this->respondWithTransformer($article);
    }

    /**
     * Delete the article video given by its slug.
     *
     * @param DeleteArticle $request
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteArticle $request, Article $article)
    {
        $article->video()->delete();

        return $this->respondSuccess();
    }
}
