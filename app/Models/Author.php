<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $table = 'author';

    //是否推荐
    const IS_HOT = 1; //是
    const NOT_IS_HOT = 0; //否

    public function authors()
    {
        return $this->hasOne(Article::class,'author_id','id');
    }
}
