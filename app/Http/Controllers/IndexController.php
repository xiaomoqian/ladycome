<?php


namespace App\Http\Controllers;


use App\Models\Ad;
use App\Models\Advert;
use App\Models\Article;
use App\Models\Author;
use App\Models\Classify;
use App\Models\Help;
use App\Models\Logo;
use App\Models\Relay;
use App\Models\Seo;
use App\Services\DataHandlingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Mockery\Exception;

class IndexController extends Controller
{
    /**
     * 首页信息【轮播图、热点推荐】
     * @param Request $request
     * @return array
     */
    public function index($limit = 10,$order_by = 'created_at'){
//        $limit = $request->get('limit',10);
//        $order_by = $request->get('order_by','created_at');
        $hotspot = DataHandlingService::index($limit);
        $questions_and_answers = DataHandlingService::questionsAndAnswers([['knowledge','=',Classify::Q_A]]);

        $science = DataHandlingService::science($order_by,[['knowledge','=',Classify::LADEL]]);
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
            'rotation' => Relay::all()->toArray(),
            'logo' => Logo::first(),
            'seo' => Seo::all()->toArray()
        ];
        return view('index',["contont" => $result,'order_by' => $order_by]);
    }

    public function science($page = 2,$order_by = 'created_at')
    {
        $science = Article::where("knowledge",'=',Article::KNOWLEDGE_SCIENCE)
            ->orderByRaw("{$order_by} desc")
            ->offset(($page - 1) * 10)
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
            $value['photo'] =   $value['photo'] != ""?
                strstr($value['photo'],'http')?
                    $value['photo']:asset("/storage/".$value['photo']):asset("/storage/images/Koala.jpg");
        }
        return $science;
    }

    /**
     * 知识页列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function knowledge($type = '',$page = 1)
    {
//        $type = $request->get('type','');
        if($type){
            $label = Classify::where('id',$type)->first();
            $where[] = ['classify_id','like','%'.$type.'%'];
            $where[] = ['knowledge','=',$label['type']];
            $seo[] = [
                'page_type' => 2,
                'seo_desc' => $label['seo_desc'],
                'seo_keywords' => $label['seo_keywords'],
                'seo_title' => $label['seo_title'],
            ];
        }else{
            $where[] = ['knowledge','=',Classify::LADEL];
            $seo = Seo::all()->toArray();
        }
        $science = DataHandlingService::science('created_at',$where??[],$page);

        $hot_seience = Article::where("knowledge",Article::KNOWLEDGE_SCIENCE)
            ->orderByRaw('reading_volume desc')
            ->limit(10)->get();
        $labels = Classify::where('type',$label['type']??Classify::LADEL)->select(['id','name'])->get()->toArray();
        $help = DataHandlingService::help();

        return view('knowledge',[
            'science' => $science,
            'hot_seience' => $hot_seience,
            'label' => $labels,
            'lable_name' => Classify::where('id',$type)->pluck('name')->first(),
            'help' => $help,  //系统设置
            'logo' => Logo::first(),
            'advert' => Ad::all()->toArray(),
            'seo' => $seo
        ]);
    }

    /**
     * 问答列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function qa($type = '')
    {
//        $type = $request->route('type','');
        if($type){
            $label = Classify::where('id',$type)->first();
//            $where[] = ['classify_id','like','%'.$type.'%'];
            $where[] = ['knowledge','=',$label['type']];
            $where[] = ['classify_id','like','%'.$type.'%'];
            $seo[] = [
                'page_type' => 3,
                'seo_desc' => $label['seo_desc'],
                'seo_keywords' => $label['seo_keywords'],
                'seo_title' => $label['seo_title'],
            ];
        }else{
            $where[] = ['knowledge','=',Classify::Q_A];
            $seo = Seo::all()->toArray();
        }
        $qa = DataHandlingService::questionsAndAnswers($where??[]);
        $hot_seience = Article::where("knowledge",Article::KNOWLEDGE_Q_A)
            ->orderByRaw('reading_volume','desc')
            ->limit(10)->get();
        $labels = Classify::where('type',$label['type']??Classify::Q_A)->select(['id','name'])->get()->toArray();
        $help = DataHandlingService::help();
        return view('qa',[
            'qa' => $qa,
            'hot_qa' => $hot_seience,
            'label' => $labels,
            'help' => $help,  //系统设置
            'lable_name' => Classify::where('id',$type)->pluck('name')->first(),
            'logo' => Logo::first(),
            'advert' => Ad::all()->toArray(),
            'seo' => $seo
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
        }
        return view('huati',[
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
    public function wdinfo($id = ''){
//        $id = $request->route('id');
        if(!$id){
            throw new Exception('参数错误');
        }
        $qa = Article::where("knowledge",Article::KNOWLEDGE_Q_A)
            ->where('id',$id)->first();
        if(!$qa){
              return view('error');
 //           return view('wdinfo',['qa' => []]);
        }
        $qa->reading_volume = intval($qa['reading_volume'] + 1);
        $qa->save();
        $qa->refresh();
        $qa['author_name'] = Author::where('id',$qa->author_id)->pluck('author_name')->first();
        $classify_id = explode(',', $qa['classify_id']);
        $classify = Classify::whereIn('id',$classify_id)->select(['id','name'])->get()->toArray();
        $qa['label'] = $classify??[];
        //获取最新问答
        $xin_qa = Article::where("knowledge",Article::KNOWLEDGE_Q_A)
            ->orderBy('created_at','desc')
            ->limit(5)->get();
        //获取最热问题
        $hot_qa = Article::where("knowledge",Article::KNOWLEDGE_Q_A)
            ->orderBy('reading_volume','desc')
            ->limit(5)->get();
        $relevant = Article::where("knowledge",Article::KNOWLEDGE_Q_A)
            ->where('classify_id',$qa['classify_id'])
            ->orderBy('reading_volume','desc')
            ->limit(5)->get();
        $help = DataHandlingService::help();
        $qa->seo_desc = mb_substr($qa->seo_desc,0,80);
        if(strlen($qa->seo_desc) >= 80){
            $qa->seo_desc = $qa->seo_desc."..........";
        }
        return view('wdinfo',[
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
    public function zsinfo($id = '')
    {
//        $id = $request->route('id');
        if(!$id){
            throw new Exception('参数错误');
        }
//        $seience = Article::where("knowledge",Article::KNOWLEDGE_SCIENCE)
//            ->where('id',$id)->first();
        $seience = Article::where('id',$id)->first();
        if(!$seience){
	     return view('error');
//            return view('zsinfo',[
//                'seience' => [],
//                'hot_seience' => [],'xin_seience' => [],'relevant' => [],
//                'help' => [],  //系统设置
//                'advert' => [],
//            ]);
        }
        $seience->reading_volume = intval($seience['reading_volume'] + 1);
        $seience->save();
        $seience['author_name'] = Author::where('id',$seience->author_id)->pluck('author_name')->first();

        $classify_id = explode(',', $seience['classify_id']);
        $classify = Classify::whereIn('id',$classify_id)->select(['id','name'])->get()->toArray();
        $seience['label'] = $classify;
        //获取最新
        $hot_seience = Article::where("knowledge",$seience->knowledge)
            ->orderBy('created_at','desc')
            ->limit(5)->get();
        //获取最热
        $xin_seience = Article::where("knowledge",$seience->knowledge)
            ->orderBy('reading_volume','desc')
            ->limit(5)->get();
        $relevant = Article::where("knowledge",$seience->knowledge)
            ->where('classify_id',$seience['classify_id'])
            ->orderBy('reading_volume','desc')
            ->limit(5)->get();
        $help = DataHandlingService::help();
        $seience->seo_desc = mb_substr($seience->seo_desc,0,80);
        if(strlen($seience->seo_desc) >= 80){
            $seience->seo_desc = $seience->seo_desc."..........";
        }
        return view('zsinfo',[
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
    public function htinfo($id = '',$orderBy = 'created_at')
    {
//        $id = $request->route('id');
//        $orderBy = $request->route('orderBy','created_at');
        if(!$id){
            throw new Exception('参数错误');
        }
        $classfiy = Classify::where('id' , $id)->first();
        if(!$classfiy){
            throw new Exception('暂无数据信息');
        }
        //获取话题分类下文章
        $science = Article::where('classify_id','like','%'.$classfiy->id.'%')
            ->where('knowledge',$classfiy->type)
            ->orderBy($orderBy,'desc')
            ->paginate(10);
        foreach ($science as $key => &$value){
            //获取作者名称
            $author = Author::where('id',$value->author_id)->first();
            $value['author_name'] = $author->name??"";
        }
        //获取广告
//        $advert = Advert::where(['advert_advert' => 3])->first();
        $classfiy->seo_desc = mb_substr($classfiy->seo_desc,0,80);
        if(strlen($classfiy->seo_desc) >= 80){
            $classfiy->seo_desc = $classfiy->seo_desc."..........";
        }
        return view('huati-info',[
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
        return view('help',[
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
    public function author($id,$orderBy = 'created_at')
    {
//        $id = $request->route('id');
//        $orderBy = $request->route('orderBy','created_at');
        if(!$id){
            throw new Exception('参数错误');
        }
        $author = Author::where('id',$id)->first();
        //获取文章列表
        $query = Article::where('author_id' , $id);
        $count = $query->count();
        $sum = $query->sum('reading_volume');
        $article = $query->orderBy($orderBy,'desc')
            ->paginate(10);
        foreach ($article as $key => &$value){
            $classify_id = explode(',', $value['classify_id']);
            $classify = Classify::whereIn('id',$classify_id)->pluck('name')->first();
            $value['label'] = $classify??"";
        }

        //获取统计数据
        return view('author',[
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
    public function search(Request $request)
    {
        $title = $request->get('title');
        $articles = Article::where('title','like',"%".$title."%")->orderBy('created_at','desc')
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
        return view('search',[
            'article' => $articles,
            'title' => $title,
            'help' => DataHandlingService::help(),  //系统设置
            'advert' => Ad::all()->toArray(),
            'logo' => Logo::first(),
        ]);
    }

}
