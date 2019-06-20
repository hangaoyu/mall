<?php

namespace App\Admin\Extensions;

use Encore\Admin\Form\Field;

use Closure;


class StepsProgress extends Field
{
    protected $callback;


    public function with(Closure $callback)
    {

        $this->callback = $callback;
    }

    public function render()
    {
        $this->view='admin.extensions.steps_progress';
        return parent::render();
    }
}