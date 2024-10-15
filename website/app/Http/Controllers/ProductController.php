<?php

namespace App\Http\Controllers;

use App\Models\CategoriesProduct;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    function add(){
        $categories = CategoriesProduct::where('parent_id', 0)->get();
        return view('admin.product.add', compact('categories'));
    }
    function store(){

    }
}
