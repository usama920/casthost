<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserContactPage extends Model
{
    use HasFactory;
    protected $table = 'users_contact_page';
    protected $fillable = [
        'user_id',
        'heading',
        'text',
        'image'
    ];
}
