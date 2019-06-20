<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\CreateButton;
use App\Models\PmsProductAttribute;
use App\Http\Controllers\Controller;
use App\Models\PmsProductAttributeCategory;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use App\Admin\Extensions\DeleteRow;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\MessageBag;


class PmsProductAttributeController extends Controller
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
            ->header('Index')
            ->description('description')
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
        $grid = new Grid(new PmsProductAttribute);


        $grid->disableExport();
        $grid->disableFilter();
        $grid->disableRowSelector();
        $grid->disableCreateButton();
        $grid->tools(function ($tools) {
            $tools->append(new CreateButton(route('attributes.create')));
        });
        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableDelete();
            $actions->disableEdit();

            $actions->append('<a href="' . route('attributes.edit', ['attribute' => $actions->getKey()]) . '"><i class="fa fa-edit"></i></a>');
            $actions->append(new DeleteRow(route('attributes.destroy', ['attribute' => $actions->getKey()])));

        });
        $product_attribute_category_id=Input::get('product_attribute_category_id');
        $grid->model()->where(['product_attribute_category_id' => $product_attribute_category_id]);
        $grid->id('编号');
        $grid->name('属性名称');
        $grid->attribureCategory()->name('商品类型');
        $grid->select_type('属性是否可选')->display(function ($value) {
            return PmsProductAttribute::$selectTypeMap[$value];
        });

        $grid->input_list('可选值列表');
        $grid->sort('排序');


        return $grid;
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new PmsProductAttribute);
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

        $form->text('name', '属性名称')->required();
        $form->select('product_attribute_category_id', '商品类型')->options(PmsProductAttributeCategory::allName())->required();

        $form->radio('select_type', '属性是否可选')->options(PmsProductAttribute::$selectTypeMap)->default(PmsProductAttribute::SELECT_TYPE_UNIQUE);

        $form->text('input_list', '属性值可选值列表')->required();

        $form->number('sort', '排序')->required()->default(0);
        $form->saved(function (Form $form) {
            $success = new MessageBag([
                'title' => '属性列表',
                'message' => '保存成功.',
            ]);
            return redirect(route('attributes.index', ['product_attribute_category_id' => $form->product_attribute_category_id, 'type_id' => $form->type]))->with(compact('success'));
        });
        return $form;
    }


}
