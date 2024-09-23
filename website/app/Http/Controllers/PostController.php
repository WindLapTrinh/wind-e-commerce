<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    function add(){

        return view("admin.post.add");
    }
    function cat(){
        return view("admin.post.cat");
    }
}
