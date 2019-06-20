<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PmsProductCategory extends Model
{
    use SoftDeletes;
    const PMS_CATEGORY_NAV_STATUS_OFF = 0;
    const PMS_CATEGORY_NAV_STATUS_ON = 1;
    public static $showStatusMap = [
        self::PMS_CATEGORY_NAV_STATUS_OFF => '否',
        self::PMS_CATEGORY_NAV_STATUS_ON => '是',
    ];
    const PMS_CATEGORY_SHOW_STATUS_OFF = 0;
    const PMS_CATEGORY_SHOW_STATUS_ON = 1;
    public static $navStatusMap = [
        self::PMS_CATEGORY_SHOW_STATUS_OFF => '否',
        self::PMS_CATEGORY_SHOW_STATUS_ON => '是',
    ];
    const PMS_CATEGORY_FIRST_LEVEL = 0;
    const PMS_CATEGORY_SECOND_LEVEL = 1;

    protected $table = 'pms_product_category';
    protected $guarded=['product_attribute_id'];

    public function scopeAllName($query)
    {
        $categories = [0 => '无上级分类'];
        $data = $query->where(['parent_id' => self::PMS_CATEGORY_FIRST_LEVEL])->select('id', 'name')->get()->toArray();
        foreach ($data as $item) {
            $categories[$item['id']] = $item['name'];
        }
        return $categories;
    }

    public function arrtibutes()
    {
        return $this->hasMany(PmsCategoryAttributeRelation::class, 'product_category_id');
    }

    public function scopeFirstLevel($query)
    {
        $data = $query->where(['parent_id' => self::PMS_CATEGORY_FIRST_LEVEL])->select('id', 'name')->get()->toArray();
        foreach ($data as $item) {
            $categories[$item['id']] = $item['name'];
        }
        return $categories;
    }

    public function scopeFirstCategory($query)
    {
        $data = $query->where(['parent_id' => self::PMS_CATEGORY_FIRST_LEVEL])->select('id')->first();
        return $data->id;

    }
}
