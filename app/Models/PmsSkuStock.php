<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PmsSkuStock extends Model
{
    use SoftDeletes;
    protected $table = 'pms_sku_stock';
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(PmsProduct::class, 'painter_id');
    }
}
