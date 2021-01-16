<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Advert;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class AdvertController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Advert(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->column('type','广告位')->using([
                '1' => 'PC页面',
                '2' => '手机页面'
            ]);
            $grid->column('advert_type','广告类型')->display(function($advert_type){
                if($advert_type == 1){
                    return  [
                        "1" => '正文下方广告',
                        '2' => '页面右侧广告1',
                        '3' => '页面右侧广告2',
                    ];
                }else{
                    return [
                        '1' => '正文下方广告',
                        '2' => '信息流广告1',
                        '3' => '信息流广告2',
                    ];
                }
            });
//                ->displayUsing('using',function ($advert_type){
//                if($advert_type == 1){
//                    return  [
//                        '1' => '正文下方广告',
//                        '2' => '页面右侧广告1',
//                        '3' => '页面右侧广告2',
//                    ];
//                }else{
//                    return [
//                        '1' => '正文下方广告',
//                        '2' => '信息流广告1',
//                        '3' => '信息流广告2',
//                    ];
//                }
//            });
            $grid->column('code','广告代码');
            $grid->created_at;
            $grid->updated_at;
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
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
        return Show::make($id, new Advert(), function (Show $show) {
            $show->id;
            $show->field('type','广告位')->using([
                '1' => 'PC页面',
                '2' => '手机页面'
            ]);
            if($this->show('type')->type == 1){
                $type =  [
                    '1' => '正文下方广告',
                    '2' => '页面右侧广告1',
                    '3' => '页面右侧广告2',
                ];
            }else{
                $type =  [
                    '1' => '正文下方广告',
                    '2' => '信息流广告1',
                    '3' => '信息流广告2',
                ];
            }
            $show->field('advert_type','广告类型')->using($type);
            $show->field('code','广告代码');
            $show->photo->image();
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
        return Form::make(new Advert(), function (Form $form) {
            $form->display('id');
            $form->select('type','广告位')->options([
                '1' => 'PC页面',
                '2' => '手机页面',
            ])->when('=', "1", function (Form $form){
                $form->select('advert_advert','广告类型')->options([
                    '1' => '正文下方广告',
                    '2' => '页面右侧广告1',
                    '3' => '页面右侧广告2',
                ]);
            })->when('=', "2", function (Form $form){
                $form->select('advert_type','广告类型')->options([
                    '1' => '正文下方广告',
                    '2' => '信息流广告1',
                    '3' => '信息流广告2',
                ]);
            });
            $form->textarea('code','广告代码');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
