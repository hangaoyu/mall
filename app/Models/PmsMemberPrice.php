<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PmsMemberPrice extends Model
{
    use SoftDeletes;
    protected $table = 'pms_member_price';
}
