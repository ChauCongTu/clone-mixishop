<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'slug', 'summary', 'desc', 'status', 'category_id',
        'product_code', 'total_quantity', 'price', 'discount_price',
        'discount_to', 'views_count', 'search_count', 'buy_count', 'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function options()
    {
        return $this->hasMany(ProductOption::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }
    public function comments()
    {
        return $this->hasMany(ProductComment::class);
    }
}
