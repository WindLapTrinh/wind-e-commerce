<?php

namespace App\Http\Controllers;

use App\Models\CategoriesProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriesProductController extends Controller
{
    //
    function list(){
        $categories = CategoriesProduct::where('parent_id', 0)->get();

        return view('admin.product.cat', compact('categories'));
    }

    function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',    
            'parent_id' => 'nullable|integer'
        ]);

        $parent_id = $request->parent_id ?? 0;
        CategoriesProduct::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'desc' => $request->desc,
            'user_id' => auth()->id(),
            'parent_id' => $parent_id,
        ]);
        return redirect()->route('category.product.list')->with('status', 'Danh mục đã được thêm !');
    }

    function showSubcategories($parentId)
    {
        // Lấy danh mục cha theo ID
        $parentCategory = CategoriesProduct::findOrFail($parentId);

        // Lấy tất cả danh mục con của danh mục cha
        $subcategories = CategoriesProduct::where('parent_id', $parentId)->get();

        // Lấy toàn bộ danh mục theo dạng cây phân cấp
        $allCategories = CategoriesProduct::where('parent_id', 0)->with('children')->get();

        return view('admin.product.subcategories', compact('parentCategory', 'subcategories', 'allCategories'));
    }
}
