<?php

namespace App\Admin\Controllers\Api;

use App\Models\PmsProductAttribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PmsProductAttributeController extends Controller
{
    //
    public function attributes(Request $request)
    {
        $product_attribute_category_id = $request->get('q');
        return PmsProductAttribute::where('product_attribute_category_id', $product_attribute_category_id)->get(['id', DB::raw('name as text')]);

    }
}
