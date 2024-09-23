<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriesPost extends Model
{
    use HasFactory;

    // Khai báo bảng được sử dụng
    protected $table = 'categories_post';

    // Khai báo các trường có thể điền dữ liệu
    protected $fillable = [
        'category_name',
        'category_slug',
        'category_desc',
        'user_id',
        'parent_id'
    ];
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
