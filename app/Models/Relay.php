<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relay extends Model
{
    //
    protected $table = 'relay';

    public static function relay()
    {
        $relays = Relay::all()->toArray();
        $data = [];
        foreach ($relays as $key => $value){
            $data[] = [
                'url' => $value['url'],
                'photo' => $value['photo'] != ""?strstr($value['photo'],'http')?$value['photo']:asset("/storage/".$value['photo']):asset("/storage/images/Koala.jpg"),
            ];
        }
        return $data;
    }
}
