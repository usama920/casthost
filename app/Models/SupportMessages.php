<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportMessages extends Model
{
    use HasFactory;
    protected $table = 'support_messages';
    protected $fillable = [
        'admin_id',
        'message',
        'subject',
        'read'
    ];

    public function admin()
    {
        return $this->hasOne(User::class, 'id', 'admin_id');
    }
}
