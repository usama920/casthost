<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminMessagesReply extends Model
{
    use HasFactory;
    protected $table = 'admin_messages_reply';
    protected $fillable = [
        'message_id',
        'reply',
    ];
}

