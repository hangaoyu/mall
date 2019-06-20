<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mockery\Exception;

class PmsProductAttributeCategory extends Model
{
    use SoftDeletes;
    protected $table = 'pms_product_attribute_category';

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $res = PmsProductAttribute::where(['product_attribute_category_id' => $model->id])->update(
                ['deleted_at' => Carbon::now()]
            );
            if (!$res) {
                throw new Exception('删除商品类型所属属性失败');
            }
        });
    }

    public function arrtibutes()
    {
        return $this->hasMany(PmsProductAttribute::class, 'product_attribute_category_id');
    }

    public function scopeAllName($query)
    {
        $arrtibute_cats = [];
        $data = $query->select('id', 'name')->get()->toArray();

        foreach ($data as $item) {
            $arrtibute_cats[$item['id']] = $item['name'];
        }
        return $arrtibute_cats;
    }

    public function scopeAllArrtibutesName($query)
    {
        $arrtibutes = [];
        $arrtibutes_cats = $query->with('arrtibutes')->get();
        foreach ($arrtibutes_cats as $arrtibutes_cat) {
            foreach ($arrtibutes_cat->arrtibutes as $item) {
                $arrtibutes[$item['id']] = $arrtibutes_cat['name'] . $item['name'];
            }
        }
        return $arrtibutes;
    }
}
