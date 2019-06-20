<?php

namespace App\Admin\Extensions;

use Encore\Admin\Form\Field;

use Closure;


class  CascaderSelect extends Field
{
    protected $callback;


    public function with(Closure $callback)
    {

        $this->callback = $callback;
    }

    public function render()
    {
        $this->view='admin.extensions.cascader_select';
        return parent::render();
    }
}