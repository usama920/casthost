<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultContactPage extends Model
{
    use HasFactory;
    protected $table = 'default_contact_page';
    protected $fillable = [
        'heading',
        'text',
        'image'
    ];
}
