<?php

namespace App\Model;

use App\Model\Feedback;
use Illuminate\Database\Eloquent\Model;


class Article extends Model
{
    //relationship with Feedback Model
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
