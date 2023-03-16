<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginPage extends Model
{
    use HasFactory;
    protected $table = 'login_page';
    protected $fillable = [
        'login_heading',
        'register_heading',
        'login_text',
        'register_text',
        'image'
    ];
}
