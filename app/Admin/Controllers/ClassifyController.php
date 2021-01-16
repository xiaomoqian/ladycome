<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Classify;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class ClassifyController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Classify(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->type->using([
                '1' => '问答',
                '2' => '知识',
                '3' => '话题',
                ]);
            $grid->name;
            $grid->column('photo','图像')->image('','80','60');
//            $grid->is_reveal->using(['0' => '否','1' => '是']);
//            $grid->is_reveal->select([
//                '0' => '否',    
//                '1' => '是',
//            ]);
//            $grid->seo_title;
//            $grid->seo_keywords;
//            $grid->seo_desc;
            $grid->created_at;
//            $grid->updated_at;
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id','分类ID');
                $filter->like('name');

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
        return Show::make($id, new Classify(), function (Show $show) {
            $show->id;
            $show->type->using([
                '1' => '问答',
                '2' => '知识',
                '3' => '话题',
            ]);
            $show->name;
            $show->photo->image();
            $show->is_reveal->using(['0' => '否','1' => '是']);
            $show->seo_title;
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
        return Form::make(new Classify(), function (Form $form) {
            $form->display('id');
            $form->select('type')->options([
                '1' => '问答',
                '2' => '知识',
                '3' => '话题',
            ]);
            $form->text('name','标签名称')->rules('required');
            $form->image('photo','图像')->retainable()->disk('public');
            $form->select('is_reveal')->options([
                '0' => '否',
                '1' => '是',
            ])->default(0);
            $form->text('seo_title')->rules('required');
            $form->text('seo_keywords')->rules('required');
            $form->text('seo_desc')->rules('required');
        });
    }
}
