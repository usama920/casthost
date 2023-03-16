<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMessagesReply extends Model
{
    use HasFactory;
    protected $table = 'user_messages_reply';
    protected $fillable = [
        'user_id',
        'message_id',
        'reply',
    ];
}

