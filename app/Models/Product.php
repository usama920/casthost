<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'user_id',
        'title',
        'main_image',
        'category_id',
        'price',
        'short_description',
        'long_description',
        'status'
    ];

    public function category()
    {
        return $this->hasOne(StoreCategories::class, 'id', 'category_id');
    }

    public function ProductOtherImages()
    {
        return $this->hasMany(ProductOtherImages::class, 'product_id', 'id');
    }
    
    public function ProductColors()
    {
        return $this->hasMany(ProductColors::class, 'product_id', 'id');
    }

    public function ProductSizes()
    {
        return $this->hasMany(ProductSizes::class, 'product_id', 'id');
    }
}
