<?php

namespace App\Admin\Extensions;

use Encore\Admin\Admin;

class CreateButton
{
    protected $create_url;

    public function __construct($create_url)
    {

        $this->create_url = $create_url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->create_url;
    }


    protected function render()
    {

        return "<div class='btn-group pull-right' style='margin -right: 10px'>
    <a href=" . $this->getUrl() . " class='btn btn-sm btn-success' title='新增'>
        <i class='fa fa-plus'></i><span class='hidden-xs'>&nbsp;&nbsp;新增</span>
    </a></div>";
    }

    public function __toString()
    {
        return $this->render();
    }
}