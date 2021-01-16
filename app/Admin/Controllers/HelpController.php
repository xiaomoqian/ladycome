<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Help;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class HelpController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Help(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->type->using([
                '1' => '关于我们',
                '2' => '联系我们',
                '3' => '版权声明',
                '4' => '加入我们',
                '5' => '入驻规则',
                '6' => '友情链接',
                '7' => '风险提示',
                '8' => '版权所有',
            ]);
            $grid->title;
            $grid->url;
            $grid->content->limit(10);
//            $grid->create_at;
//            $grid->update_at;
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('title');

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
        return Show::make($id, new Help(), function (Show $show) {
            $show->id;
            $show->type->using([
                '1' => '关于我们',
                '2' => '联系我们',
                '3' => '版权声明',
                '4' => '加入我们',
                '5' => '入驻规则',
                '6' => '友情链接',
                '7' => '风险提示',
                '8' => '版权所有',
            ]);
            $show->title;
            $show->url;
            $show->content->unescape();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
//        1=关于我们 2= 3= 4=  5=
        return Form::make(new Help(), function (Form $form) {
            $form->display('id');
            $form->select('type')->options([
                '1' => '关于我们',
                '2' => '联系我们',
                '3' => '版权声明',
                '4' => '加入我们',
                '5' => '入驻规则',
                '6' => '友情链接',
                '7' => '风险提示',
                '8' => '版权所有',
            ]);
            $form->text('title')->rules('required');
            $form->editor('content')->default('');
            $form->url('url')->default('#');
        });
    }
}
