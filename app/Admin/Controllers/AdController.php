<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Ad;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Illuminate\Http\Request;

class AdController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Ad(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->column('type','广告位')->using([
                '1' => 'PC页面',
                '2' => '手机页面'
            ]);
            $grid->column('advert_type','广告类型')->using([
                "1" => '详情页广告',
                '2' => '页面右侧广告1',
                '3' => '页面右侧广告2',
                '4' => '工具栏广告',
                '6' => '详情页广告1',
                '7' => '详情页广告2',
                '8' => '工具栏广告',
                '9' => '页面右侧广告1',
                '10' => '页面右侧广告2',
            ]);
            $grid->column('code','广告代码')->limit(20);
            $grid->created_at;
//            $grid->updated_at;
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
        return Show::make($id, new Ad(), function (Show $show) {
            $show->id;
            $show->field('type','广告位')->using([
                '1' => 'PC页面',
                '2' => '手机页面'
            ]);
            $show->field('advert_type','广告类型')->using([
                "1" => '详情页广告',
                '2' => '页面右侧广告1',
                '3' => '页面右侧广告2',
                '4' => '工具栏广告',
                '6' => '详情页广告1',
                '7' => '详情页广告2',
                '8' => '工具栏广告',
                '9' => '页面右侧广告1',
                '10' => '页面右侧广告2',
            ]);
            $show->field('code','广告代码');
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
        return Form::make(new Ad(), function (Form $form) {
            $form->display('id');
            $form->select('type','广告位')->options([
                '1' => 'PC页面',
                '2' => '手机页面',
            ])->load('advert_type','/a');
            $form->select('advert_type','广告类型');
            $form->textarea('code','广告代码');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }

    public function a(Request $request)
    {
        $q = $request->get('q');
        if($q == 1){
            return [
                [
                    "id" =>  1,
                     "text" =>  "详情页广告"
                ],
                [
                    "id" =>  2,
                    "text" =>  "页面右侧广告1"
                ],
                [
                         "id" =>  3,
                         "text" =>  "页面右侧广告2"
                ],
                [
                    "id" =>  4,
                     "text" =>  "工具栏广告"
                ]
            ];
        }else{
            return [
                [
                    "id" =>  6,
                    "text" =>  "详情页广告1"
                ],
                [
                    "id" =>  7,
                    "text" =>  "详情页广告2"
                ],
                [
                    "id" =>  8,
                    "text" =>  "工具栏广告"
                ],
                [
                    "id" =>  9,
                    "text" =>  "页面右侧广告1"
                ],
                [
                    "id" =>  10,
                    "text" =>  "页面右侧广告2"
                ]
            ];
        }
    }
}
