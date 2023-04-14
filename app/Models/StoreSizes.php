<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreSizes extends Model
{
    use HasFactory;
    protected $table = 'store_sizes';
    protected $fillable = [
        'user_id',
        'title',
        'status'
    ];
}
