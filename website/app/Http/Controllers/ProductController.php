<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    function add(){

        return redirect('admin/product/add');
    }
}
