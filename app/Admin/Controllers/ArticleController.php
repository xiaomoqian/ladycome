<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Article;
use App\Models\Author;
use App\Models\Classify;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class ArticleController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Article(), function (Grid $grid) {
            $grid->model()->orderBy('created_at','desc');
            $grid->id;
//            $grid->author_id;
//            $grid->classify_id;
//            $grid->column('author_name','作者名称')->display(function() {
//                $author = Author::where(['id' => $this->grid()->author_id])->first();
//                return $author->author_name??"";
//            });
            $grid->column('classify_id', '标签')
                ->display(function($classify_id) {
                    $classify_id = explode(',', $classify_id);
                    $classify = Classify::whereIn('id',$classify_id)->get()->toArray();
                    $str="";
                    foreach ($classify as $key => $value){
                        $str.=$value['name'].",";
                    }
                    return  substr($str,0,strlen($str)-1);
                });

            $grid->title->limit(15);
//            $grid->contont;
//            $grid->contont->limit(15);
//            $grid->photo->image();
//            $grid->is_hot->using(['0' => '否','1' => '是']);
//            $grid->reading_volume;
            $grid->column('knowledge','文章类型')->using(['0' => '未知','1' => '问答', '2' => '知识', '3' => '话题',]);
//            $grid->seo_title;
//            $grid->seo_keywords;
//            $grid->seo_desc;
            $grid->created_at;
//            $grid->updated_at;
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id','文章ID');
                $filter->like('title');
                $filter->like('contont');
                $filter->like('seo_keywords','关键词');
                $filter->like('seo_desc','文章描述');
                $filter->equal('knowledge', '文章类型')
                    ->select([
                        '1' => '问答',
                        '2' => '知识',
                        '3' => '话题',
                    ])->load('classify_id','/cfy');
                $filter->equal('classify_id','文章标签')
                    ->select(['classify_id']);
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Article(), function (Show $show) {
            $show->field('author_name','作者名称')->as(function () {
                $author = Author::where(['id' => $this->show('author_id','作者名称')->author_id])->first();
                return $author->author_name;
            });
            $show->field('name','分类名称')->as(function () {
                $classify_id = explode(',', $this->show('classify_id','分类名称')->classify_id);
                $classify = Classify::whereIn('id',$classify_id)->select('name')->get()->toArray();
                $name = implode(',',array_column($classify,'name'));
                return $name??"";
            });
            $show->field('title','文章标题');
            $show->field('contont','文章内容')->unescape();
            $show->field('photo','文章图片')->image();
            $show->field('file','文章视频')->file();
            $show->is_hot->using(['0' => '否','1' => '是']);
            $show->reading_volume;
            $show->knowledge->using(['0' => '未知','1' => '问答', '2' => '知识文章', '3' => '话题',]);
            $show->seo_title;
            $show->field('short_answer','短答案');
            $show->seo_keywords;
            $show->seo_desc;
            $show->created_at;
            $show->updated_at;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Article(), function (Form $form) {
            $user =  Auth::guard('admin')->user()->toArray();
            if($user['auth'] == 1){
                $author = Author::all()->toArray();
                $ids = array_column($author,'author_name','id');
                $form->select('author_id','发布人')->options($ids)->rules('required');
            }else{
                $form->hidden('author_id');
            }

            $form->select('knowledge', '文章类型')
                ->options([
                    '1' => '问答',
                    '2' => '知识',
                    '3' => '话题',
                ])->load('classify_id','/cfy');
            $form->select('classify_id','文章标签');
            $form->text('title','文章标题')->rules('required');
            $form->editor('contont','文章内容')->rules('required');
            $photo = rand(1,20);

            $form->image('photo','文章图片');//->default("images/{$photo}.jpg");
            $form->file('file','文章视频')->maxSize(102400);

            $form->radio('is_hot')->options(['0' => '否','1' => '是'])->default('0')->rules('required');
            $form->text('reading_volume')->default(0)->rules('required');
            $form->hidden('seo_title');
            // $form->hidden('seo_keywords');
            $form->text('short_answer','短答案');
            $form->text('seo_keywords','文章keywords')->rules('required');
            $form->textarea('seo_desc','文章描述')->rules('required');
            $form->display('created_at');
            $form->display('updated_at');

            $form->saving(function (Form $form) {
                if(!$form->photo){

                    $disk = Storage::disk('public');
                    $photo = rand(1,115);
                    $uuid = Uuid::uuid4();
                    // 拷贝文件 第一个参数是要拷贝的文件，第二个参数是拷贝到哪里
                    $disk->copy("artice/{$photo}.jpg","artice1/".$uuid.".jpg");
                    $form->photo = "artice1/{$uuid}.jpg";
                }
                if($form->isCreating()){
                    $user =  Auth::guard('admin')->user()->toArray();
                    if($user['auth'] != 1){
                        $author = Author::where(['user_id' => $user['id']])->first();
                        $form->author_id = $author->id;
                    }
                    $form->seo_title = '标题 - 多广';
                    // $form->seo_keywords = '标题';
                }
            });
        });
    }

    public function cfy(Request $request)
    {
        $q = $request->get('q');
        $classify = Classify::all()->where('type',$q)->toArray();
        $classify_ids = [];
        foreach ($classify as $key => $value){
            $classify_ids[] = [
                "id" =>  $value['id'],
                "text" =>  $value['name']
            ];
        }
//        $classify_ids = array_column($classify,'name','id');
        if(!$classify_ids){
            $classify_ids = [
                [
                    "id" =>  0,
                    "text" =>  "无"
                ]
            ];
        }
        return $classify_ids;
    }
}
