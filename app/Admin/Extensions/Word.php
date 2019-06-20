<?php

namespace App\Admin\Extensions;

use Encore\Admin\Form\Field;

use Closure;


class Word extends Field
{
    protected $callback;


    public function with(Closure $callback)
    {

        $this->callback = $callback;
    }

    public function render()
    {
        $word = $this->column;
        return view('admin.extensions.word', compact('word'));

    }
}