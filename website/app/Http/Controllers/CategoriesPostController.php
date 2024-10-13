<?php

namespace App\Http\Controllers;

use App\Models\CategoriesPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriesPostController extends Controller
{
    //add
    function add()
    {
        $categories = CategoriesPost::where('parent_id', 0)->get();

        return view('admin.post.cat', compact('categories'));
    }

    function getSubcategories($parentId)
    {
        $subcategories = CategoriesPost::where('parent_id', $parentId)->get();

        return response()->json($subcategories);
    }

    function showSubcategories($parentId)
    {
        $parentCategory = CategoriesPost::findOrFail($parentId);

        $subcategories = CategoriesPost::where('parent_id', $parentId)->get();

        return view('admin.post.subcategories', compact('parentCategory', 'subcategories'));
    }

    function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'parent_id' => 'nullable|integer',
        ]);

        $parent_id = $request->parent_id ?? 0;

        CategoriesPost::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'desc' => $request->desc,
            'user_id' => auth()->id(),
            'parent_id' => $parent_id,
        ]);

        return redirect()->route('category.post.add')->with('status', 'Danh mục đã được thêm!');
    }

    //update
    public function update(Request $request, $id)
    {
        $category = CategoriesPost::findOrFail($id);
        $category->update([
            'name' => $request->input('name'),
            'desc' => $request->input('desc'),
            'slug' => Str::slug($request->name),
            'parent_id' => $request->input('parent_id'),
        ]);

        return redirect()->route('category.post.add')->with('status', 'Cập nhật danh mục thành công');
    }
    // delete 
    public function delete($id)
    {
        $category = CategoriesPost::find($id);

        if ($category) {
            $this->deleteSubcategories($category->id);

            $category->delete();
        }

        return redirect()->route('category.post.add')->with('status', 'Đã xóa danh mục và các danh mục con thành công');
    }

    private function deleteSubcategories($parentId)
    {
        $subcategories = CategoriesPost::where('parent_id', $parentId)->get();

        foreach ($subcategories as $subcategory) {
            $this->deleteSubcategories($subcategory->id);
            $subcategory->delete();
        }
    }
}
