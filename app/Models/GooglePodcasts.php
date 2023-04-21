<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GooglePodcasts extends Model
{
    use HasFactory;
    protected $table = 'google_podcasts';
    protected $fillable = [
        'user_id',
        'url'
    ];
}
