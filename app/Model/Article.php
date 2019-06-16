<?php

namespace App\Model;

use App\Model\Feedback;
use Illuminate\Database\Eloquent\Model;


class Article extends Model
{
    // handle both mass and single updates
    protected $fillable = [
        'title', 'details', 'price', 'availableCopies', 'discount'
    ];
    //relationship with Feedback Model
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
