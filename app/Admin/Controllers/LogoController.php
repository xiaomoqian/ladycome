<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Logo;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class LogoController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Logo(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->logo->image();
        
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
        return Show::make($id, new Logo(), function (Show $show) {
            $show->id;
            $show->logo->image();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Logo(), function (Form $form) {
            $form->display('id');
            $form->image('logo');
        });
    }
}
