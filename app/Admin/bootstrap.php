<?php
use Encore\Admin\Admin;
/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

Admin::css('https://unpkg.com/element-ui/lib/theme-chalk/index.css');
Admin::headerJs('https://unpkg.com/vue/dist/vue.js');
Admin::headerJs('https://unpkg.com/element-ui/lib/index.js');
Encore\Admin\Form::forget(['map', 'editor']);
\Encore\Admin\Form::extend('stepsProgress', \App\Admin\Extensions\StepsProgress::class);
\Encore\Admin\Form::extend('word', \App\Admin\Extensions\Word::class);
\Encore\Admin\Form::extend('cascaderSelect', \App\Admin\Extensions\CascaderSelect::class);
\Encore\Admin\Form::extend('discountWay', \App\Admin\Extensions\DiscountWay::class);
\Encore\Admin\Form::extend('productHelp', \App\Admin\Extensions\ProductFormHelp::class);
Admin::js('/js/admin/product.js');