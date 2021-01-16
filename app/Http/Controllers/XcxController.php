<?php


namespace App\Http\Controllers;


use App\Models\Ad;
use App\Models\Article;
use App\Models\Author;
use App\Models\Classify;
use App\Models\Help;
use App\Models\Logo;
use App\Models\Relay;
use App\Models\Seo;
use App\Services\DataHandlingService;
use Illuminate\Http\Request;
use Mockery\Exception;

class XcxController extends Controller
{
    /**
     * 首页信息【轮播图、热点推荐】
     * @param Request $request
     * @return array
     */
    public function index(Request $request){
        $limit = $request->get('limit',10);
        $order_by = $request->get('order_by','created_at');
        $hotspot = DataHandlingService::index($limit);
        $questions_and_answers = DataHandlingService::questionsAndAnswers();
        $science = DataHandlingService::science($order_by);
        $tc = DataHandlingService::tc();
        $author = DataHandlingService::author();
        $help = DataHandlingService::help();
        $result = [
            'hotspot' => $hotspot,//热点
            'questions_and_answers' => $questions_and_answers, //问答
            'science' => $science, //知识
            'tc' => $tc,  //话题
            'author' => $author, //作者
            'help' => $help,  //系统设置
            'rotation' => Relay::relay(),
            'logo' => Logo::first(),
            'seo' => Seo::all()->toArray()
        ];
        return self::json($result);
    }

    public function science(Request $request)
    {
        $page = $request->get('page',2);
        $order_by = $request->get('order_by','created_at');

        $query = Article::where("knowledge",'=',Article::KNOWLEDGE_SCIENCE)
            ->orderByRaw("$order_by desc");
        $count = $query->count();
        $science = $query->offset(($page - 1) * 10)
            ->limit(10)->get();
        $author_ids = array_column($science->toArray(),'author_id');
        $authors = Author::whereIn('id',$author_ids)->select(['author_name','id'])->get()->toArray();
        $names = array_column($authors,'author_name','id');
        foreach ($science as $key => &$value){
            //获取标签
            $classify_id = explode(',', $value['classify_id']);
            $classify = Classify::whereIn('id',$classify_id)->select(['id','name'])->get()->toArray();
            $value->label = $classify;
            //获取作者名称
            $value->author_name = $names[$value['author_id']]??"";
            $value['photo'] = $value['photo'] != ""?strstr($value['photo'],'http')?$value['photo']:asset("/storage/".$value['photo']):asset("/storage/images/Koala.jpg");
        }
        return self::json([
            'list' => $science,
            'count' => $count,
            'page' => $page,
            'page_size' => 10
        ]);
    }

    /**
     * 知识页列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function knowledge(Request $request)
    {
        $type = $request->get('type','');
        $orderBy = $request->get('orderBy','created_at');
        if($type){
            $label = Classify::where('id',$type)->first();
            $where[] = ['classify_id','like','%'.$type.'%'];
            $where[] = ['knowledge','=',$label['type']];
        }
        $science = DataHandlingService::science($orderBy,$where??[]);

        $hot_seience = Article::where("knowledge",Article::KNOWLEDGE_SCIENCE)
            ->orderByRaw('reading_volume desc')
            ->limit(10)->get();
        $labels = Classify::where('type',$label['type']??Classify::LADEL)->select(['id','name'])->get()->toArray();
        $help = DataHandlingService::help();
        return self::json([
            'science' => $science,
            'hot_seience' => $hot_seience,
            'label' => $labels,
            'lable_name' => Classify::where('id',$type)->pluck('name')->first(),
            'help' => $help,  //系统设置
            'logo' => Logo::first(),
            'advert' => Ad::all()->toArray(),
            'seo' => Seo::all()->toArray()
        ]);
    }

    /**
     * 问答列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function qa(Request $request)
    {
        $type = $request->get('type','');
        if($type){
            $label = Classify::where('id',$type)->first();
//            $where[] = ['classify_id','like','%'.$type.'%'];
            $where[] = ['knowledge','=',$label['type']];
            $where[] = ['classify_id','like','%'.$type.'%'];
        }else{
            $where[] = ['knowledge','=',Article::KNOWLEDGE_Q_A];
        }
        $qa = DataHandlingService::questionsAndAnswers($where??[]);
        $hot_seience = Article::where("knowledge",Article::KNOWLEDGE_Q_A)
            ->orderByRaw('reading_volume','desc')
            ->limit(10)->get();
        $labels = Classify::where('type',$label['type']??Classify::Q_A)->select(['id','name'])->get()->toArray();
        $help = DataHandlingService::help();
        return self::json([
            'qa' => $qa,
            'hot_qa' => $hot_seience,
            'label' => $labels,
            'help' => $help,  //系统设置
            'lable_name' => Classify::where('id',$type)->pluck('name')->first(),
            'logo' => Logo::first(),
            'advert' => Ad::all()->toArray(),
            'seo' => Seo::all()->toArray()
        ]);
    }

    /**
     * 话题分类列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ht()
    {
        $classfiy = Classify::where(['type' => Classify::ARTICLE])->paginate(10);
        foreach ($classfiy as $key => &$value){
            $value['articel_count'] = Article::where('classify_id','like','%'.$value->id.'%')
                ->where('knowledge',Classify::ARTICLE)
                ->count();
            $value['photo'] = $value['photo'] != ""?strstr($value['photo'],'http')?$value['photo']:asset("/storage/".$value['photo']):asset("/storage/images/Koala.jpg");
        }
        return self::json([
            'classfiy' => $classfiy,
            'help' => DataHandlingService::help(),  //系统设置
            'advert' => Ad::all()->toArray(),
            'logo' => Logo::first(),
            'seo' => Seo::all()->toArray()
        ]);
    }

    /**
     *问答详情
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function wddetails(Request $request){
        $id = $request->get('id','');
        if(!$id){
            return self::json([],1,'参数错误');
        }
        $qa = Article::where("knowledge",Article::KNOWLEDGE_Q_A)
            ->where('id',$id)->first();
        if(!$qa){
            return self::json([]);
        }
        $qa->reading_volume = intval($qa['reading_volume'] + 1);
        $qa->save();
        $qa['author_name'] = Author::where('id',$qa->author_id)->pluck('author_name')->first();
        $classify_id = explode(',', $qa['classify_id']);
        $classify = Classify::whereIn('id',$classify_id)->select(['id','name'])->get()->toArray();
        $qa['label'] = $classify;
        $qa['photo'] = $qa['photo'] != ""?strstr($qa['photo'],'http')?$qa['photo']:asset("/storage/".$qa['photo']):asset("/storage/images/Koala.jpg");
        //获取最新问答
        $xin_qa = Article::where("knowledge",Article::KNOWLEDGE_Q_A)
            ->orderByRaw('created_at desc')
            ->limit(5)->get();
        foreach ($xin_qa as $key => &$value){
            $value['photo'] = $value['photo'] != ""?strstr($value['photo'],'http')?$value['photo']:asset("/storage/".$value['photo']):asset("/storage/images/Koala.jpg");
        }
        //获取最热问题
        $hot_qa = Article::where("knowledge",Article::KNOWLEDGE_Q_A)
            ->orderByRaw('reading_volume desc')
            ->limit(5)->get();
        foreach ($hot_qa as $k => &$v){
            $v['photo'] = $v['photo'] != ""?strstr($v['photo'],'http')?$v['photo']:asset("/storage/".$v['photo']):asset("/storage/images/Koala.jpg");
        }
        $relevant = Article::where("knowledge",Article::KNOWLEDGE_Q_A)
            ->where('classify_id',$qa['classify_id'])
            ->orderByRaw('reading_volume desc')
            ->limit(5)->get();
        foreach ($relevant as $y => &$e){
            $e['photo'] = $e['photo'] != ""?strstr($e['photo'],'http')?$e['photo']:asset("/storage/".$e['photo']):asset("/storage/images/Koala.jpg");
        }
        $help = DataHandlingService::help();
        return self::json([
            'qa' => $qa,
            'hot_qa' => $hot_qa,
            'xin_qa' => $xin_qa,
            'relevant' => $relevant,
            'help' => $help,  //系统设置
            'advert' => Ad::all()->toArray(),
            'logo' => Logo::first(),
        ]);
    }

    /**
     * 知识详情
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function zsdetails(Request $request)
    {
        $id = $request->get('id','');
        if(!$id){
            return self::json([],1,'参数错误');
        }
//        $seience = Article::where("knowledge",Article::KNOWLEDGE_SCIENCE)
//            ->where('id',$id)->first();
        $seience = Article::where('id',$id)->first();
        if(!$seience){
            return self::json([]);
        }
        $seience->reading_volume = intval($seience['reading_volume'] + 1);
        $seience->save();
        $seience['author_name'] = Author::where('id',$seience->author_id)->pluck('author_name')->first();

        $classify_id = explode(',', $seience['classify_id']);
        $classify = Classify::whereIn('id',$classify_id)->select(['id','name'])->get()->toArray();
        $seience['label'] = $classify;
        $seience['photo'] = $seience['photo'] != ""?strstr($seience['photo'],'http')?$seience['photo']:asset("/storage/".$seience['photo']):asset("/storage/images/Koala.jpg");
        //获取最新
        $hot_seience = Article::where("knowledge",$seience->knowledge)
            ->orderByRaw('created_at desc')
            ->limit(5)->get();
        foreach ($hot_seience as $key => &$value){
            $value['photo'] = $value['photo'] != ""?strstr($value['photo'],'http')?$value['photo']:asset("/storage/".$value['photo']):asset("/storage/images/Koala.jpg");
        }
        //获取最热
        $xin_seience = Article::where("knowledge",$seience->knowledge)
            ->orderByRaw('reading_volume desc')
            ->limit(5)->get();
        foreach ($hot_seience as $k => &$v){
            $v['photo'] = $v['photo'] != ""?strstr($v['photo'],'http')?$v['photo']:asset("/storage/".$v['photo']):asset("/storage/images/Koala.jpg");
        }
        $relevant = Article::where("knowledge",$seience->knowledge)
            ->where('classify_id',$seience['classify_id'])
            ->orderByRaw('reading_volume desc')
            ->limit(5)->get();
        foreach ($relevant as $y => &$e){
            $e['photo'] = $e['photo'] != ""?strstr($e['photo'],'http')?$e['photo']:asset("/storage/".$e['photo']):asset("/storage/images/Koala.jpg");
        }
        $help = DataHandlingService::help();
        return self::json([
            'seience' => $seience,
            'hot_seience' => $hot_seience,
            'xin_seience' => $xin_seience,
            'relevant' => $relevant,
            'help' => $help,  //系统设置
            'advert' => Ad::all()->toArray(),
            'logo' => Logo::first(),
        ]);
    }

    /**
     * 话题分类详情
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function htdetails(Request $request)
    {
        $id = $request->get('id','');
        $orderBy = $request->get('order_by','created_at');
        if(!$id){
            return self::json([],1,'参数错误');
        }
        $classfiy = Classify::where('id' , $id)->first();
        if(!$classfiy){
            return self::json([],1,'暂无数据信息');
        }
        $classfiy['photo'] = $classfiy['photo'] != ""?strstr($classfiy['photo'],'http')?$classfiy['photo']:asset("/storage/".$classfiy['photo']):asset("/storage/images/Koala.jpg");
        //获取话题分类下文章
        $science = Article::where('classify_id','like','%'.$classfiy->id.'%')
            ->where('knowledge',$classfiy->type)
            ->orderByRaw("{$orderBy} desc")
            ->paginate(10);
        foreach ($science as $key => &$value){
            //获取作者名称
            $author = Author::where('id',$value->author_id)->first();
            $value['author_name'] = $author->name??"";
            $value['photo'] = $value['photo'] != ""?strstr($value['photo'],'http')?$value['photo']:asset("/storage/".$value['photo']):asset("/storage/images/Koala.jpg");
        }
        //获取广告
//        $advert = Advert::where(['advert_advert' => 3])->first();
        return self::json([
            'classty' => $classfiy,
            'science' => $science,
            'advert' => Ad::all()->toArray(),
            'orderBy' => $orderBy,
            'help' => DataHandlingService::help(),  //系统设置
            'logo' => Logo::first(),
        ]);
    }

    /**
     * 帮助页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function help($type = '')
    {
        switch ($type){
            case "contact":
                $type = 2;
//                $htlps = Help::where('type',2)->first();
                break;
            case "copy":
                $type = 3;
//                $htlps = Help::where('type',3)->first();
                break;
            case "job":
                $type = 4;
//                $htlps = Help::where('type',4)->first();
                break;
            case "join":
                $type = 5;
//                $htlps = Help::where('type',5)->first();
                break;
            default:
                $type = 1;
                break;
        }
        $htlps = Help::where('type',$type)->first();
        return self::json([
            'help' => DataHandlingService::help(),  //系统设置
            'helps' => $htlps,  //系统设置
            'logo' => Logo::first(),
            'type' => $type,
        ]);
    }

    /**
     * 作者列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function authors(Request $request)
    {
        $id = $request->get('id');
        $orderBy = $request->get('orderBy','created_at');
        if(!$id){
            return self::json([],1,'参数错误');
        }
        $author = Author::where('id',$id)->first();
        $author['photo'] = $author['photo'] != ""?strstr($author['photo'],'http')?$author['photo']:asset("/storage/".$author['photo']):asset("/storage/images/Koala.jpg");
        //获取文章列表
        $query = Article::where('author_id' , $id);
        $count = $query->count();
        $sum = $query->sum('reading_volume');
        $article = $query->orderByRaw("{$orderBy} desc")
            ->paginate(10);
        foreach ($article as $key => &$value){
            $classify_id = explode(',', $value['classify_id']);
            $classify = Classify::whereIn('id',$classify_id)->pluck('name')->first();
            $value['label'] = $classify??"";
            $value['photo'] = $value['photo'] != ""?strstr($value['photo'],'http')?$value['photo']:asset("/storage/".$value['photo']):asset("/storage/images/Koala.jpg");
        }

        //获取统计数据
        return self::json([
            'author' => $author,
            'article' => $article,
            'count' => $count,
            'sum' => $sum,
            'orderBy' => $orderBy,
            'help' => DataHandlingService::help(),  //系统设置
            'logo' => Logo::first(),
        ]);
    }

    /**
     * 头部搜索
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchs(Request $request)
    {
        $title = $request->get('title');
        $articles = Article::where('title','like',"%".$title."%")->orderByRaw('created_at desc')
            ->paginate(10);
        $author_ids = array_column($articles->toArray(),'author_id');
        $authors = Author::whereIn('id',$author_ids)->select(['author_name','id'])->get()->toArray();
        $names = array_column($authors,'author_name','id');
        foreach ($articles as $key => &$value){
            //获取标签
//            $classify_id = explode(',', $value['classify_id']);
//            $classify = Classify::whereIn('id',$classify_id)->select(['id','name'])->get()->toArray();
//            $value->label = $classify;
            //获取作者名称
            $value->author_name = $names[$value['author_id']]??"";
        }
        return self::json([
            'article' => $articles,
            'title' => $title,
            'help' => DataHandlingService::help(),  //系统设置
            'advert' => Ad::all()->toArray(),
            'logo' => Logo::first(),
        ]);
    }

    protected static function json($data,$code = 0,$message = ""){
        return json_encode(['data' => $data,'code' => $code,'message' => $message]);
    }
}
