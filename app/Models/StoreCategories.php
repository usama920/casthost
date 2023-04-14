<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreCategories extends Model
{
    use HasFactory;
    protected $table = 'store_categories';
    protected $fillable = [
        'user_id',
        'title',
        'status'
    ];
}
