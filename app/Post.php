<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
       // return $this->belongsTo('App\User', 'id', 'user_id');
    }
}
