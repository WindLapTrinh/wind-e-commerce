<?php

namespace App\Http\Controllers;

use App\Models\CategoriesPost;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class PostController extends Controller
{
    //
    function list()
    {
        $posts = Post::with(['category', 'image'])->get();
        $categories = CategoriesPost::where('parent_id', 0)->get();

        return view('admin.post.list', compact('posts', 'categories'));
    }
    function add()
    {
        $categories = CategoriesPost::where('parent_id', 0)->get();

        return view("admin.post.add", compact('categories'));
    }
    public function store(Request $request)
    {
        // Validate form data
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|exists:categories_post,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published,pending,archived', // Validate giá trị status là một trong các enum
        ]);

        // Lưu ảnh vào bảng images
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageSize = $image->getSize(); // Lấy kích thước trước khi di chuyển
            $imageName = time() . '-' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);

            // Tạo bản ghi trong bảng images
            $imageModel = new Image();
            $imageModel->url = 'images/' . $imageName;
            $imageModel->name = $imageModel->url;
            $imageModel->size = $imageSize; // Lưu kích thước
            $imageModel->user_id = auth()->id(); // Gán ID của người dùng nếu cần thiết
            $imageModel->save();
        }

        // Lưu bài viết vào bảng posts
        $post = new Post();
        $post->title = $request->input('title');
        $post->slug = Str::slug($request->input('title'));
        $post->excerpt = Str::limit($request->input('content'), 100);
        $post->content = $request->input('content');
        $post->status = $request->input('status'); // Gán giá trị status từ form
        $post->category_id = $request->input('category');
        $post->user_id = auth()->id(); // Lấy ID của người dùng đăng nhập hiện tại
        $post->image_id = $imageModel->id; // Gán ID của ảnh

        $post->save();

        return redirect()->route('post.list')->with('status', 'Bài viết đã được thêm thành công');
    }

    public function update(Request $request)
{
    $post = Post::find($request->post_id);
    
    // Nếu có upload ảnh mới
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        
        // Kiểm tra xem tệp có hợp lệ hay không
        if ($image->isValid()) {
            $imageSize = $image->getSize();
            $imageName = time() . '-' . $image->getClientOriginalName();
            
            // Lưu tệp vào thư mục 'public/images'
            $image->move(public_path('images'), $imageName);
            
            // Xóa ảnh cũ từ hệ thống
            if ($post->image) {
                // Xóa tệp ảnh cũ nếu tồn tại
                Storage::delete($post->image->url);
                // Xóa bản ghi ảnh cũ trong bảng images
                $post->image->delete();
            }

            // Tạo bản ghi trong bảng images cho ảnh mới
            $imageModel = new Image();
            $imageModel->url = 'images/' . $imageName;
            $imageModel->name = $imageModel->url;
            $imageModel->size = $imageSize;
            $imageModel->user_id = auth()->id();
            $imageModel->save();

            // Cập nhật image_id trong bài viết
            $post->image_id = $imageModel->id;
        } else {
            return redirect()->back()->withErrors(['error' => 'Tệp ảnh không hợp lệ.']);
        }
    }

    // Cập nhật các thông tin khác của bài viết
    $post->title = $request->title;
    $post->content = $request->content;
    $post->category_id = $request->category_id;
    $post->status = $request->status;

    $post->save(); // Lưu các thay đổi

    return redirect()->route('post.list')->with('status', 'Bài viết đã được cập nhật thành công.');
}

    function delete() {}

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
