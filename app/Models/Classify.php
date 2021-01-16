<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Classify extends Model
{
	const LADEL = 2; //知识
	const Q_A = 1;  //问答
	const ARTICLE = 3; //话题
    protected $table = 'classify';
    
}
