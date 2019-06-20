<?php

namespace App\Admin\Controllers;

use App\Models\PmsBrand;
use App\Models\PmsProduct;
use App\Http\Controllers\Controller;
use App\Models\PmsProductAttributeCategory;
use App\Models\PmsProductCategory;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class PmsProductController extends Controller
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
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
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
        $grid = new Grid(new PmsProduct);

        $grid->id('ID');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

        return $grid;
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new PmsProduct);


//        $form->stepsProgress('ID');

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
//        $form->ignore(['product_category']);

        $form->select('product_category', '商品分类')->options(PmsProductCategory::firstLevel())->load('product_category_id', route('admin.api.pms_categories'))->setWidth(2)->required();
        $form->select('product_category_id', '')->setWidth(2);
        $form->text('name', '商品名称')->required()->default('aa');
        $form->text('sub_title', '副标题')->required()->default('qqq');
        $form->select('brand_id', '商品品牌')->options(PmsBrand::allName())->setWidth(2);
        $form->textarea('description', '商品介绍');
        $form->text('product_sn', '商品货号')->required()->default('qweqw');
        $form->currency('price', '商品售价')->symbol('元');
        $form->currency('original_price', '市场价')->symbol('元');
        $form->number('stock', '商品库存')->required()->default(0);
        $form->number('sort', '排序')->required()->default(0);
        $form->text('unit', '计量单位');
        $form->currency('weight', '商品重量')->symbol('克');
        $form->number('gift_point', '赠送积分')->default(0);
        $form->number('gift_growth', '赠送成长值')->default(0);
        $form->number('use_point_limit', '积分购买限制')->default(0);
        $form->text('detail_title', '详细页标题');
        $form->text('detail_desc', '详细页描述');
        $form->text('keywords', '商品关键字');
        $form->textarea('note', '商品备注');
        $states = [
            'on' => ['value' => PmsProduct::STATUS_ON, 'text' => '开启', 'color' => 'success'],
            'off' => ['value' => PmsProduct::STATUS_OFF, 'text' => '关闭', 'color' => 'danger'],
        ];
            $form->switch('preview_status', "预告商品")->states($states);
            $form->switch('new_status', "新品")->states($states);
            $form->switch('recommand_status', "推荐")->states($states);
            $publish_states = [
                'on' => ['value' => PmsProduct::PUBLISH_STATUS_ON, 'text' => '上架', 'color' => 'success'],
                'off' => ['value' => PmsProduct::PUBLISH_STATUS_DOWN, 'text' => '下架', 'color' => 'danger'],
            ];
            $form->switch('publish_status', "商品上架")->states($publish_states);
            $form->checkbox('service_ids', '服务保障')->options(PmsProduct::$servicesMap);
            $form->discountWay('promotion_type', '选择优惠方式')->options(PmsProduct::$promotionsMap);
            $form->hasMany('ladders','', function (Form\NestedForm $form) {
                $form->number('count', '数量')->required()->default(0);
                $form->rate('discount', '折扣');
            });

            $form->hasMany('fullreduces','', function (Form\NestedForm $form) {
                $form->currency('full_price', '满')->symbol('元');
                $form->currency('reduce_price', '立减')->symbol('元');
            });


            $form->hasMany('skus', '商品 SKU', function (Form\NestedForm $form) {
                $form->text('description', 'SKU 描述')->rules('required');
                $form->currency('price', '单价')->symbol('元');
                $form->number('stock', '库存')->required()->default(0);
                $form->number('low_stock', '预警库存')->required()->default(0);
                $form->text('sku_code', 'sku编码')->creationRules(['required', "unique:pms_sku_stock,sku_code"])
                    ->updateRules(['required', "unique:pms_sku_stock,sku_code,{{id}}"]);
            });

            $form->hasMany('arrtibutes', '商品属性', function (Form\NestedForm $form) {
                $form->text('name', '属性名')->rules('required');
                $form->text('value', '属性值')->rules('required');
            });


        return $form;
    }
}
