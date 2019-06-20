<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PmsBrand extends Model
{
    use SoftDeletes;

    const PMS_BRAND_SHOW_STATUS_ON = 1;
    const PMS_BRAND_SHOW_STATUS_OFF = 0;

    protected $table = "pms_brand";
    protected $guarded=[];

    public function scopeAllName($query)
    {
        $brands = [];
        $data = $query->select('id', 'name')->get()->toArray();

        foreach ($data as $item) {
            $brands[$item['id']] = $item['name'];
        }
        return $brands;
    }
}
