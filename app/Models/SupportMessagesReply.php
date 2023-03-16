<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportMessagesReply extends Model
{
    use HasFactory;
    protected $table = 'support_messages_reply';
    protected $fillable = [
        'support_message_id',
        'reply'
    ];
}
