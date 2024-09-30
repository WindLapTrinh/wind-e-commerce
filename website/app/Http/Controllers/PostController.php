<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    function list(){
        return view('admin.post.list');
    }
    function add()
    {

        return view("admin.post.add");
    }
    function cat()
    {
        return view("admin.post.cat");
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048', // Kiểm tra file upload
        ]);

        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $filename); // Lưu hình ảnh vào thư mục images

            return response()->json(['location' => asset('images/' . $filename)]); // Trả về đường dẫn hình ảnh
        }

        return response()->json(['error' => 'Some error occurred during uploading.'], 500);
    }
}
