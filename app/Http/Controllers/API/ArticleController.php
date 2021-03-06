<?php

namespace App\Http\Controllers\API;

use App\Model\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticleResource;
use App\Http\Resources\Article\ArticleCollection;
use App\Http\Requests\ArticleRequest;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index', 'show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ArticleCollection::collection(Article::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $article = new Article;
        $article->title = $request->title;
        $article->details = $request->content;
        $article->price = $request->price;
        $article->availableCopies = $request->stock;
        $article->discount = $request->discount;
        $article->save();
        return response([
            'data' => new ArticleResource($article)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {

        // When column name is different from the request, we need to assign that to the correct column and disable it.
        $request['details'] = $request->content;
        $request['availableCopies'] = $request->stock;
        unset($request['content'], $request['stock']);
        $article->update($request->all());
        return response([
            'data' => new ArticleResource($article)
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
