<?php

namespace App\Admin\Controllers;


use App\Models\PmsProductAttributeCategory;
use App\Models\PmsProductCategory;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Support\Facades\Input;

class PmsProductCategoryController extends Controller
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
            ->header('商品分类')
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

        $grid = new Grid(new PmsProductCategory);
        $parent_id = (Input::get('parent_id'));
        if (is_null($parent_id)) {
            $grid->model()->where(['parent_id' => PmsProductCategory::PMS_CATEGORY_FIRST_LEVEL]);
        } else {
            $grid->model()->where(['parent_id' => $parent_id]);
        }
        $grid->disableExport();
        $grid->disableFilter();
        $grid->actions(function ($actions) {
            $actions->disableView();
        });


        $grid->id('编号');
        $grid->name('品牌名称');
        $grid->level('级别')->display(function ($value) {
            return ($value == PmsProductCategory::PMS_CATEGORY_FIRST_LEVEL) ? "一级" : "二级";
        });
        $grid->product_count('商品数量');
        $grid->product_unit('数量单位');
        $grid->sort('排序');
        $states = [
            'on' => ['value' => PmsProductCategory::PMS_CATEGORY_SHOW_STATUS_ON, 'text' => '显示', 'color' => 'success'],
            'off' => ['value' => PmsProductCategory::PMS_CATEGORY_SHOW_STATUS_OFF, 'text' => '隐藏', 'color' => 'danger'],
        ];
        $grid->nav_status('导航栏显示')->switch($states);
        $grid->show_status('是否显示')->switch($states);
        $grid->text('设置')->display(function () {
            if ($this->parent_id != PmsProductCategory::PMS_CATEGORY_FIRST_LEVEL) {
                return "<button class='label label-default' disabled='disabled'>查看下级</button> ";
            } else {
                return "<a class='label label-primary' href='" . route('categories.index') . "?parent_id=" . $this->id . "'>查看下级</a> ";
            }
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
        $form = new Form(new PmsProductCategory);
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
        $form->text('name', '分类名称')->required();
        $form->select('parent_id', '上级分类')->options(PmsProductCategory::allName())->required();
        $form->text('product_unit', '数量单位');
        $form->number('sort', '排序')->required()->rules('required|regex:/^\d+$/', [
            'regex' => 'sort值必须为数字',
        ])->default(0);


        $states = [
            'on' => ['value' => PmsProductCategory::PMS_CATEGORY_SHOW_STATUS_ON, 'text' => '显示', 'color' => 'success'],
            'off' => ['value' => PmsProductCategory::PMS_CATEGORY_SHOW_STATUS_OFF, 'text' => '隐藏', 'color' => 'danger'],
        ];

        $form->switch('show_status', "是否显示")->states($states);
        $form->switch('nav_status', "是否显示在导航栏")->states($states);
        $form->image('icon', '分类图标');
        $form->text('keywords', '关键词');
        $form->textarea('description', '分类描述');

        $form->saving(function ($form) {
            $form->level = ($form->parent_id == PmsProductCategory::PMS_CATEGORY_FIRST_LEVEL) ? PmsProductCategory::PMS_CATEGORY_FIRST_LEVEL : PmsProductCategory:: PMS_CATEGORY_SECOND_LEVEL;
        });
        return $form;
    }
}
