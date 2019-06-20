<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PmsFeightTemplate extends Model
{
    use SoftDeletes;
    protected $table = 'pms_feight_template';
}
