<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    //

    function add(){
        return view("admin.permission.add");
    }

    function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required',
            // 'description' => "nullable"
        ]);

        //Insert db
        Permission::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'description' => $request->input('description'),
        ]);

        return redirect()-> route('permission.add')-> with('status', 'Đã thêm quyền thành công');
    }

}
