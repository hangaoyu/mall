<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class PmsCategoryAttributeRelation extends Model
{
    public $timestamps = false;
    protected $guarded = ['product_attribute_category_id'];
    protected $table = 'pms_product_category_attribute_relation';
}
