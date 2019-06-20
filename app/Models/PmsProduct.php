<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PmsProduct extends Model
{
    use SoftDeletes;

    protected $table = 'pms_product';

    const STATUS_ON = 1;
    const STATUS_OFF = 0;

    const PREVIEW_STATUS_ON = 1;
    const PREVIEW_STATUS_OFF = 0;

    const PUBLISH_STATUS_ON = 1;
    const PUBLISH_STATUS_DOWN = 0;

    const NEW_STATUS_ON = 1;
    const NEW_STATUS_OFF = 0;

    const RECOMMAND_STATUS_ON = 1;
    const RECOMMAND_STATUS_OFF = 0;

    const VERIFY_STATUS_ON = 1;
    const VERIFY_STATUS_OFF = 0;

    public static $servicesMap = [
        1 => '无忧退货',
        2 => '快速退款',
        3 => '免费包邮',
    ];

    public static $promotionsMap = [
        0 => '无优惠',
        1 => '特惠促销',
        2 => '会员价格',
        3 => '阶梯价格',
        4 => '使用满减价格',
    ];

    public function ladders()
    {
        return $this->hasMany(PmsLadder::class, 'product_id');
    }

    public function fullreduces()
    {
        return $this->hasMany(PmsFullReduction::class, 'product_id');
    }

    public function skus(){
        return $this->hasMany(PmsSkuStock::class, 'product_id');
    }

    public function arrtibutes(){
        return $this->hasMany(PmsProductAttributeValue::class, 'product_id');
    }
}
