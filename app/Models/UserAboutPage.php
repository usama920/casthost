<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAboutPage extends Model
{
    use HasFactory;
    protected $table = 'users_about_page';
    protected $fillable = [
        'user_id',
        'heading',
        'text',
        'profile_image',
        'cover_image'
    ];
}
