<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Khai báo bảng được sử dụng
    protected $table = 'posts';

    // Khai báo các trường có thể điền dữ liệu
    protected $fillable = [
        'post_title',
        'post_slug',
        'post_excerpt',
        'post_content',
        'post_status',
        'user_id',
        'category_id',
        'image_id'
    ];

    // Quan hệ: Mỗi bài viết thuộc về một danh mục
    public function category()
    {
        return $this->belongsTo(CategoriesPost::class, 'category_id');
    }
}
