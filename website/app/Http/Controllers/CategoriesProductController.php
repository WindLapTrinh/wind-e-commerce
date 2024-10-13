<?php

namespace App\Http\Controllers;

use App\Models\CategoriesProduct;
use Illuminate\Http\Request;

class CategoriesProductController extends Controller
{
    //
    function add(){
        $categories = CategoriesProduct::where('parent_id', 0)->get();

        return view('admin.product.cat', compact('categories'));
    }
}
