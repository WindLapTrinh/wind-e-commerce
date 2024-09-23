<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriesPostController extends Controller
{
    //
    function add(){
        return view('admin.post.cat');
    }
    function store(Request $request){
        
    }
}
