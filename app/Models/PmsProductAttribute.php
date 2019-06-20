<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class PmsProductAttribute extends Model
{
    use SoftDeletes;
    const ARRTIBUTE_SPECIFICATION = 0;
    const ARRTIBUTE_PARAMETERS = 1;

    public static $TypeMap = [
        self::ARRTIBUTE_SPECIFICATION => '规格',
        self::ARRTIBUTE_PARAMETERS => '参数',
    ];

    const SELECT_TYPE_UNIQUE = 0;
    const SELECT_TYPE_SINGLE = 1;
    const SELECT_TYPE_MULTI = 2;
    public static $selectTypeMap = [
        self::SELECT_TYPE_UNIQUE => '唯一',
        self::SELECT_TYPE_SINGLE => '单选',
        self::SELECT_TYPE_MULTI => '多选',
    ];

    const INPUT_TYPE_MANUAL = 0;
    const INPUT_TYPE_LIST = 1;
    public static $inputTypeMap = [
        self::INPUT_TYPE_MANUAL => '手动录入',
        self::INPUT_TYPE_LIST => '从列表中选取',


    ];


    protected $table = 'pms_product_attribute';

    public static function boot()
    {
        parent::boot();
//保存前类型所属参数数量加1
        static::created(function ($model) {
            $res = PmsProductAttributeCategory::where('id', $model->product_attribute_category_id)
                ->update(array(
                    'param_count' => DB::raw('param_count + 1'),
                ));
            if (!$res) {
                throw new Exception('增加类型属性/参数数量出错');
            }


        });
//删除后类型所属参数数量减1
        static::deleting(function ($model) {

            $res = PmsProductAttributeCategory::where('id', $model->product_attribute_category_id)
                ->update(array(
                    'param_count' => DB::raw('param_count - 1'),
                ));

            if (!$res) {
                throw new Exception('减少类型属性/参数数量出错');
            }
        });
    }

    public function attribureCategory()
    {
        return $this->belongsTo(PmsProductAttributeCategory::class, 'product_attribute_category_id');
    }


}
