<?php

namespace App\Http\Resources\Article;

use Illuminate\Http\Resources\Json\Resource;

class ArticleCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'rating' => $this->feedbacks->count() > 0 ? round($this->feedbacks->sum('rating') / $this->feedbacks->count()) : 'No Ratings Yet',
            'totalPrice' => round($this->price * (1 - ($this->discount / 100)), 2),
            'href' => [
                'fullArticle' => route('articles.show', $this->id)
            ]
        ];
    }
}
