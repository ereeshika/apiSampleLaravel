<?php

namespace App\Model;

use App\Model\Article;
use Illuminate\Database\Eloquent\Model;


class Feedback extends Model
{
    // relationship with Articles table
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
