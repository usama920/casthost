<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHomePage extends Model
{
    use HasFactory;
    protected $table = 'users_home_page';
    protected $fillable = [
        'user_id',
        'image'
    ];
}
