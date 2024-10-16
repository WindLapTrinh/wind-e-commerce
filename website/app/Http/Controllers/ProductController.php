<?php

namespace App\Http\Controllers;

use App\Models\CategoriesProduct;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    //
    function list(Request $request)
    {
        $products = Product::paginate(10);

        $categories = CategoriesProduct::all();

        $keyword = $request->input('keyword');

        return view('admin.product.list', compact('products', 'categories', 'keyword'));
    }
    function add()
    {
        $categories = CategoriesProduct::where('parent_id', 0)->get();
        return view('admin.product.add', compact('categories'));
    }
    function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:products,slug|max:255',
            'price' => 'required|integer',
            'stock_quantity' => 'required|integer',
            'category_id' => 'required|exists:categories_product,id',
            'image' => 'nullable|image|max:2048'
        ]);

        //new product
        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->desc = $request->desc;
        $product->detalis = $request->details;
        $product->price = $request->price;
        $product->stock_quantity = $request->stock_quantity;
        $product->is_featured = $request->is_featured;
        $product->product_status = $request->product_status;
        $product->category_id = $request->category_id;
        $product->user_id = auth()->id();

        $product->save();
        
        // Xử lý ảnh nếu có
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageSize = $image->getSize();
            $imageName = time() . '-' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
    
            // Tạo bản ghi trong bảng images
            $imageModel = new Image();
            $imageModel->url = 'images/' . $imageName;
            $imageModel->name = $imageModel->url;
            $imageModel->size = $imageSize;
            $imageModel->user_id = auth()->id();
            $imageModel->save();
    
            // Lưu vào bảng trung gian product_image
            $productImage = new ProductImage();
            $productImage->product_id = $product->id;
            $productImage->image_id = $imageModel->id;
            $productImage->save();
        }
        return redirect()->back()->with('status', 'Thêm sản phẩm thành công!');
    }
}
