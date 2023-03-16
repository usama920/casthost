<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultAboutPage extends Model
{
    use HasFactory;
    protected $table = 'default_about_page';
    protected $fillable = [
        'heading',
        'text',
        'profile_image',
        'cover_image'
    ];
}
