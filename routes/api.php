<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::Resource('/articles', 'TestApi\ArticleController');
Route::apiResource('/articles', 'API\ArticleController');

Route::group(['prefix' => 'articles'], function () {
    Route::apiResource('/{article}/feedbacks', 'API\FeedBackController');
});
