<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Author;
use App\Models\AdminUsers;
use App\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Models\Repositories\Administrator;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthorController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Author(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->author_name;
            $grid->column('user_name','登录账户');
//                ->display(function() {
//                $admin = AdminUsers::where(['id' => $this->grid()->user_id])->first();
//                return $admin->username??"";
//            });
            $grid->desc;
            $grid->certification_mark;
            $grid->photo->image();
            $grid->field;
            $grid->is_hot->using(['0' => '否','1' => '是']);
            $grid->created_at;
            $grid->updated_at->sortable();
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('author_name');

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
        return Show::make($id, new Author(), function (Show $show) {
            $show->id;
//            $show->user_id;
            $show->field('user_name','登录账户');
//                ->as(function () {
//                $admin = AdminUsers::where(['id' => $this->show('user_id','登录者')->user_id])->first();
//                return $admin->username??"";
//            });
            $show->field('password','登录密码')->as(function () {
//                $admin = AdminUsers::where(['id' => $this->show('user_id','登录者')->user_id])->first();
//                return $admin->password??"";
                return "**********";
            });
            $show->author_name;
            $show->desc;
            $show->certification_mark;
            $show->photo->image();
            $show->field;
            $show->is_hot->using(['0' => '否','1' => '是']);
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
        return Form::make(new Author(), function (Form $form) {
            $form->display('id');
//            $form->text('user_name')->rules('required|unique,user_name',['required' => '账号不能为空','unique' => '账号已存在']);
            $form->text('user_name')->rules('required',['required' => '账号不能为空']);
            $form->password('user_password')->rules('required',['密码不能为空']);
            $form->text('author_name')->rules('required',['作者名称不能为空']);
            $form->text('desc')->rules('required',['作者简介不能为空']);
            $form->text('certification_mark')->rules('required',['作者认证标识不能为空']);
            $form->image('photo')->rules('required',['作者图像不能为空'])->disk('public');
            $form->text('field')->rules('required',['作者擅长领域不能为空']);
            $form->radio('is_hot')->options(['0' => '否','1' => '是'])->default('0');
            $form->display('created_at');
            $form->display('updated_at');
            $form->hidden('user_id');
            $form->saving(function (Form $form) {

                if($form->isCreating()){
                    $name = AdminUsers::where('username',$form->user_name)->count();
                    if($name > 0){
                        return response()->json(['message' => '登录账户已存在']);
                    }
                    $admin = new AdminUsers();
                    $admin->username = $form->user_name;
                    $admin->name = $form->author_name;
                    $admin->password = Hash::make($form->user_password);
                    $admin->auth = 2;
                    $admin->save();
                    $admin->refresh();//刷新model
                    $form->user_id = $admin->id;
                    $form->user_password = Hash::make($form->user_password);
                }else{
                    $admin = AdminUsers::where('id',$form->model()->user_id)->first();
                    if ($form->user_name && $form->author_name ){
                        $admin->username = $form->user_name;
                        $admin->name = $form->author_name;
                    }


//                    $admin->password = Hash::make($form->user_password);
                    if ($form->user_password && $admin->password != $form->user_password) {
                        $admin->password = Hash::make($form->user_password);
                        $form->user_password = Hash::make($form->user_password);
                    }
                    $admin->save();
                }
            });
        });
    }
}
