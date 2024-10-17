<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";

    protected $fillable = [
        'name',
        'slug',
        'desc',
        'details',
        'price',
        'stock_quantity',
        'is_featured',
        'product_status',
        'user_id',
        'category_id'
    ];
}
