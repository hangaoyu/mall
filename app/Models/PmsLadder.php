<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PmsLadder extends Model
{
    use SoftDeletes;
    protected $table = 'pms_product_ladder';
}
