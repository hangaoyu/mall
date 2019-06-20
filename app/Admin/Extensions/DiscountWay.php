<?php

namespace App\Admin\Extensions;

use Encore\Admin\Form\Field;

use Closure;


class DiscountWay extends Field
{
    protected $callback;


    public function with(Closure $callback)
    {

        $this->callback = $callback;
    }

    public function render()
    {

        $this->view='admin.extensions.discount_way';
        return parent::render();
    }
}