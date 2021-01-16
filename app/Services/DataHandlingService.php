<?php


namespace App\Services;


use App\Http\Controllers\AcademyPaginator;
use App\Models\Article;
use App\Models\Author;
use App\Models\Classify;
use App\Models\Help;

class DataHandlingService
{
    /**
     * 首页信息【轮播图、热点推荐】
     * @param int $limit
     * @return mixed
     */
    public static function index($limit = 10)
    {
        $hotspot = Article::where("is_hot",'=',Article::IS_HOT)
            ->orderByRaw('reading_volume desc')
            ->limit($limit)
            ->get()->toArray();
        return $hotspot;
    }

    /**
     * 获取问答列表
     * @return array
     */
    public static function questionsAndAnswers($where = [])
    {
//        $hotspot = Article::where("knowledge",Article::KNOWLEDGE_Q_A)
        $hotspot = Article::where($where)
            ->orderByRaw('created_at desc')
//            ->orderByRaw('reading_volume desc')
            ->paginate(10);

        $author_ids = array_column($hotspot->toArray()['data']??"",'author_id');
        $authors = Author::whereIn('id',$author_ids)->select(['author_name','id'])->get()->toArray();
        $names = array_column($authors,'author_name','id');
        foreach ($hotspot as $key => &$value){
            $value->author_name = $names[$value->author_id]??"";
            $value->photo = $value->photo != ""?strstr($value->photo,'http')?$value->photo:asset("/storage/".$value->photo):asset("/storage/images/Koala.jpg");
        }
        return $hotspot;
    }

    /**
     * 获取知识列表
     * @param string $order_by
     * @return array
     */
    public static function science($order_by = 'created_at',$where = [],$page = 1)
    {
//        $science = Article::where("knowledge",'=',Article::KNOWLEDGE_SCIENCE)
        $science = Article::where($where)
//            ->orderByRaw($order_by,"desc")
            ->orderByRaw("{$order_by} desc")
//            ->offset(($page - 1) * 10)
//            ->limit(10)->get();
            ->paginate(10);
        $author_ids = array_column($science->toArray()['data'],'author_id');

        $authors = Author::whereIn('id',$author_ids)->select(['author_name','id'])->get()->toArray();
        $names = array_column($authors,'author_name','id');
        foreach ($science as $key => &$value){
            //获取标签
            $classify_id = explode(',', $value['classify_id']);
            $classify = Classify::whereIn('id',$classify_id)->select(['id','name'])->get()->toArray();
            $value->label = $classify;
            //获取作者名称
            $value->author_name = $names[$value['author_id']]??"";
            $value->photo = $value->photo != ""?strstr($value['photo'],'http')?$value['photo']:asset("/storage/".$value['photo']):asset("/storage/images/Koala.jpg");
        }
        return $science;
    }

    /**
     * 获取话题列表
     * @return mixed
     */
    public static function tc()
    {
        $classfi = Classify::where(['type' => Classify::ARTICLE])->limit(5)->get();
        return $classfi;
    }

    /**
     * 获取作者信息列表
     * @return array
     */
    public static function author()
    {
        $author = Author::where('is_hot',Author::IS_HOT)->orderByRaw('created_at desc')->limit(10)->get();
        return $author;
    }

    /**
     * 获取系统设置信息
     * @return array
     */
    public static function help()
    {
        $help = Help::all()->groupBy('type')->toArray();
        return $help;
    }
}
