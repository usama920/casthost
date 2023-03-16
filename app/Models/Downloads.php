<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Downloads extends Model
{
    use HasFactory;
    protected $table = "downloads";
    protected $fillable = [
        'podcast_id',
        'user_id'
    ];
}
