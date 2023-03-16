<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultHomePage extends Model
{
    use HasFactory;
    protected $table = 'default_home_page';
    protected $fillable = [
        'image'
    ];
}
