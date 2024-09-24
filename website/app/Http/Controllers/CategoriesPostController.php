<?php

namespace App\Http\Controllers;

use App\Models\CategoriesPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriesPostController extends Controller
{
    //
    function add()
    {
        // Lấy danh sách tất cả danh mục
        $categories = CategoriesPost::all();

        // Truyền danh sách danh mục sang view
        return view('admin.post.cat', compact('categories'));
    }
    function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories_post,id',
        ]);

        // Nếu không chọn danh mục cha, gán parent_id là 0
        $parent_id = $request->parent_id ? $request->parent_id : 0;
        
        // Thêm danh mục mới
        CategoriesPost::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'desc' => $request->desc,
            'user_id' => auth()->id(),
            'parent_id' => $parent_id,
        ]);
        
        return redirect()->route('category.post.add')->with('status', 'Danh mục đã được thêm!');
    }
}
