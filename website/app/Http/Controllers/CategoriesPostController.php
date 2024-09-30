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
        // Lấy danh sách các danh mục cha (parent_id = 0)
        $categories = CategoriesPost::where('parent_id', 0)->get();

        // Truyền danh sách danh mục cha sang view
        return view('admin.post.cat', compact('categories'));
    }

    function getSubcategories($parentId)
    {
        // Lấy danh mục con dựa trên parent_id
        $subcategories = CategoriesPost::where('parent_id', $parentId)->get();

        // Trả về dưới dạng JSON cho AJAX request
        return response()->json($subcategories);
    }

    function showSubcategories($parentId)
    {
        // Lấy danh mục cha
        $parentCategory = CategoriesPost::findOrFail($parentId);

        // Lấy tất cả danh mục con của danh mục cha hiện tại (đa cấp)
        $subcategories = CategoriesPost::where('parent_id', $parentId)->get();

        // Truyền dữ liệu sang view để hiển thị
        return view('admin.post.subcategories', compact('parentCategory', 'subcategories'));
    }

    function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'parent_id' => 'nullable|integer',
        ]);

        // Nếu không chọn danh mục cha, gán parent_id là 0
        $parent_id = $request->parent_id ?? 0;

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
        // Find the category by its ID
        $category = CategoriesPost::find($id);

        // If the category exists
        if ($category) {
            // Delete all child categories recursively
            $this->deleteSubcategories($category->id);

            // Delete the parent category
            $category->delete();
        }

        return redirect()->route('category.post.add')->with('status', 'Đã xóa danh mục và các danh mục con thành công');
    }

    // Recursive function to delete subcategories
    private function deleteSubcategories($parentId)
    {
        // Get all child categories
        $subcategories = CategoriesPost::where('parent_id', $parentId)->get();

        // Loop through each subcategory
        foreach ($subcategories as $subcategory) {
            // Delete subcategories of this subcategory
            $this->deleteSubcategories($subcategory->id);

            // Delete the subcategory
            $subcategory->delete();
        }
    }
}
