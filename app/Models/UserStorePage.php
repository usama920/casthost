<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStorePage extends Model
{
    use HasFactory;
    protected $table = 'users_store_page';
    protected $fillable = [
        'user_id',
        'heading',
        'image'
    ];
}
