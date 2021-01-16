<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $table = 'article';

    //是否热点推荐
    const IS_HOT = 1; //是
    const NOT_IS_HOT = 0; //否

    //文章类型
    const KNOWLEDGE_Q_A = 1;//问答
    const KNOWLEDGE_SCIENCE = 2;//知识
    const KNOWLEDGE_T_C = 3;//话题

    protected $datas = ['deleted_at'];

    public function author()
    {
        return $this->belongsTo(Author::class,'author_id');
    }
    // public function getClassifyAttribute($value)
    // {
    //     return explode(',', $value);
    // }

    // public function setClassifyIdAttribute($value)
    // {
    //     //tags 是分类字段名 我的叫tags
    //     $this->attributes['classify_id'] = implode(',', $value);
    // }

}
