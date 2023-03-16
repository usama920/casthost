<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserContact extends Model
{
    use HasFactory;
    protected $table = 'user_contact';
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'message',
        'subject',
        'read'
    ];
}

