<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    //
    public function list()
    {
        $images = Image::with('user')->get();
        return view('admin.images.list', compact('images'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'image_url' => 'required|string',
            'file_size' => 'nullable|integer',
            'file_name' => 'nullable|string',
        ]);

        // Lưu vào bảng images
        $image = new Image();
        $image->url = $validatedData['image_url'];
        $image->name = $validatedData['file_name'] ?? 'Unnamed';
        $image->size = $validatedData['file_size'] ?? 0;
        $image->user_id = auth()->id();
        $image->save();

        return response()->json(['success' => true]);
    }
}
