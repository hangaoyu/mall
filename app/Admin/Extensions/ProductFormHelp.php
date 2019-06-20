<?php

namespace App\Admin\Extensions;

use Encore\Admin\Form\Field;

use Closure;


class ProductFormHelp extends Field
{
    protected $callback;


    public function with(Closure $callback)
    {

        $this->callback = $callback;
    }

    public function render()
    {
        return view('admin.extensions.product_help');
    }
}