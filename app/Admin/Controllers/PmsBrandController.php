<?php

namespace App\Admin\Controllers;


use App\Http\Controllers\Controller;
use App\Models\PmsBrand;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;


class PmsBrandController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('品牌管理')
            ->description('数据列表')
            ->body($this->grid());
    }


    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }



    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

        $grid = new Grid(new PmsBrand);
        $grid->disableExport();
        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->like('name', '品牌名称');
        });

        $grid->actions(function ($actions) {
            $actions->disableView();
        });
        $grid->id('编号');
        $grid->name('品牌名称');
        $grid->first_letter('品牌首字母');
        $grid->sort('排序');
        $states = [
            'on'  => ['value' => PmsBrand::PMS_BRAND_SHOW_STATUS_ON, 'text' => '打开', 'color' => 'success'],
            'off' => ['value' => PmsBrand::PMS_BRAND_SHOW_STATUS_OFF, 'text' => '关闭', 'color' => 'danger'],
        ];
        $grid->show_status('是否显示')->switch($states);
        $grid->text('相关')->display(function() {
            return "商品：".$this->product_count.' '.'评价：'.$this->product_comment_count;
        });


        return $grid;
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new PmsBrand);
        $form->tools(function (Form\Tools $tools) {
            // 去掉`列表`按钮
            $tools->disableList();
            // 去掉`删除`按钮
            $tools->disableDelete();
            // 去掉`查看`按钮
            $tools->disableView();
        });
        $form->footer(function ($footer) {
            // 去掉`重置`按钮
            $footer->disableReset();
            // 去掉`查看`checkbox
            $footer->disableViewCheck();
            // 去掉`继续编辑`checkbox
            $footer->disableEditingCheck();
            // 去掉`继续创建`checkbox
            $footer->disableCreatingCheck();
        });

        $form->text('name', '品牌名称')->required();
        $form->text('first_letter', '品牌首字母')->required();
        $form->number('sort', '排序')->required()->default(0);
        $form->image('logo','品牌Logo')->required();
        $form->image('big_pic','品牌大图');
        $form->text('brand_story', '品牌故事');
        $states = [
            'on'  => ['value' => PmsBrand::PMS_BRAND_SHOW_STATUS_ON, 'text' => '打开', 'color' => 'success'],
            'off' => ['value' => PmsBrand::PMS_BRAND_SHOW_STATUS_OFF, 'text' => '关闭', 'color' => 'danger'],
        ];

        $form->switch('show_status', "是否开启")->states($states);
        $form->display('created_at', '创建时间');
        $form->display('updated_at', '修改时间');


        return $form;
    }
}
