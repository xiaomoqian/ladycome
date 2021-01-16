<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Relay;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class RelayController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Relay(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->photo->image();
            $grid->url;
            $grid->desc;
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
        return Show::make($id, new Relay(), function (Show $show) {
            $show->id;
            $show->photo;
            $show->url;
            $show->desc;
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
        return Form::make(new Relay(), function (Form $form) {
            $form->display('id');
            $form->image('photo')->rules('required')->disk('public');
            $form->url('url')->rules('required');
            $form->text('desc');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
