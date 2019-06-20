<?php

namespace App\Admin\Controllers\Api;

use App\Models\PmsProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PmsProductCategoryController extends Controller
{
    //
    public function categories(Request $request)
    {
        $product_category_id = $request->get('q');
        return PmsProductCategory::where('parent_id', $product_category_id)->get(['id', DB::raw('name as text')]);
    }
}
