<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscribers extends Model
{
    use HasFactory;
    protected $table = 'user_subscribers';
    protected $fillable = [
        'subscriber_id',
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
