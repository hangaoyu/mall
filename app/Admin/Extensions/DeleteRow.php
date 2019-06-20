<?php

namespace App\Admin\Extensions;

use Encore\Admin\Admin;

class DeleteRow
{
    protected $delete_url;

    public function __construct($delete_url)
    {

        $this->delete_url = $delete_url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->delete_url;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return csrf_token();
    }

    protected function script()
    {
        $trans = [
            'delete_confirm' => trans('admin.delete_confirm'),
            'confirm' => trans('admin.confirm'),
            'cancel' => trans('admin.cancel'),
        ];
        return <<<SCRIPT

$('.grid-delete-row').on('click', function () {

     swal({
        title: "{$trans['delete_confirm']}",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "{$trans['confirm']}",
        showLoaderOnConfirm: true,
        cancelButtonText: "{$trans['cancel']}",
        preConfirm: function() {
            return new Promise(function(resolve) {
                $.ajax({
                    method: 'post',
                    url: '{$this->getUrl()}',
                    data: {
                        _method:'delete',
                        _token:'{$this->getToken()}'
                    },
                    success: function (data) {
                        $.pjax.reload('#pjax-container');
                        resolve(data);
                    }
                });
            });
        }
    }).then(function(result) {
        var data = result.value;
        if (typeof data === 'object') {
            if (data.status) {
                swal(data.message, '', 'success');
            } else {
                swal(data.message, '', 'error');
            }
        }
    });

});

SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());

        return "<a class='grid-delete-row'><i class=\"fa fa-trash\"></i></a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}