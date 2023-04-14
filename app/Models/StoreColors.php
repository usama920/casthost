<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreColors extends Model
{
    use HasFactory;
    protected $table = 'store_colors';
    protected $fillable = [
        'user_id',
        'title',
        'status'
    ];
}
