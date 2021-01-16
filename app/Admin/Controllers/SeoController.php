<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Seo;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class SeoController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Seo(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->page_type->using([
                '1' => '首页',
                '2' => '知识列表',
                '3' => '问答列表',
                '4' => '话题列表',
                '5' => '房贷计算器',
                '6' => '公积金计算器',
                '7' => '组合贷款计算器',
                '8' => '提前还款计算器',
                '9' => '理财收益计算器',
                '10' => '工资计算器',
                '11' => '年终奖计算器',
                '12' => '五险一金计算器',
            ]);
            $grid->seo_title;
            $grid->seo_keywords;
            $grid->seo_desc;
            $grid->created_at;
            $grid->updated_at->sortable();
        
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
        return Show::make($id, new Seo(), function (Show $show) {
            $show->id;
            $show->page_type->using([
                '1' => '首页',
                '2' => '知识列表',
                '3' => '问答列表',
                '4' => '话题列表',
                '5' => '房贷计算器',
                '6' => '公积金计算器',
                '7' => '组合贷款计算器',
                '8' => '提前还款计算器',
                '9' => '理财收益计算器',
                '10' => '工资计算器',
                '11' => '年终奖计算器',
                '12' => '五险一金计算器',
            ]);
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
        return Form::make(new Seo(), function (Form $form) {
            $form->display('id');
            $form->select('page_type')->options([
                '1' => '首页',
                '2' => '知识列表',
                '3' => '问答列表',
                '4' => '话题列表',
                '5' => '房贷计算器',
                '6' => '公积金计算器',
                '7' => '组合贷款计算器',
                '8' => '提前还款计算器',
                '9' => '理财收益计算器',
                '10' => '工资计算器',
                '11' => '年终奖计算器',
                '12' => '五险一金计算器',
            ]);
            $form->text('seo_title');
            $form->text('seo_keywords');
            $form->text('seo_desc');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
