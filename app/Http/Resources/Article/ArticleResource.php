<?php

namespace App\Http\Resources\Article;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'content' => $this->details,
            'price' => $this->price,
            'stock' => $this->availableCopies == 0 ? 'No Stocks available' : $this->availableCopies,
            'discount' => $this->discount == 0 ? 'No Discounts' : $this->discount,
            'rating' => $this->feedbacks->count() > 0 ? round($this->feedbacks->sum('rating') / $this->feedbacks->count()) : 'No Ratings Yet',
            'comments' => $this->feedbacks->count('commment') > 0 ? $this->feedbacks->count('commment') : 'Be the First one to Comment',
            'href' => [
                'feedbacks' => route('feedbacks.index', $this->id)
            ]
        ];
    }
}
