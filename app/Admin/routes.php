<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('products', 'PmsProductController');
    $router->resource('brands', 'PmsBrandController');
    $router->resource('categories', 'PmsProductCategoryController');
    $router->resource('types', 'PmsProductAttributeCategoryController');

    $router->get('attributes', 'PmsProductAttributeController@index')->name('attributes.index');
    $router->get('attributes/create','PmsProductAttributeController@create')->name('attributes.create');
    $router->post('attributes','PmsProductAttributeController@store')->name('attributes.store');
    $router->get('attributes/{attribute}/edit','PmsProductAttributeController@edit')->name('attributes.edit');
    $router->put('attributes/{attribute}','PmsProductAttributeController@update')->name('attributes.update');
    $router->delete('attributes/{attribute}','PmsProductAttributeController@destroy')->name('attributes.destroy');

});

Route::group([
    'prefix'        => config('admin.route.prefix').'/api',
    'namespace'     => config('admin.route.namespace').'\\Api',
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('attributes','PmsProductAttributeController@attributes')->name('admin.api.pms_attributes');
    $router->get('categories','PmsProductCategoryController@categories')->name('admin.api.pms_categories');

});
