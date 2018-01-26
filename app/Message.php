<?php

namespace Chatty;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['from_user_id', 'to_user_id', 'conversation_id', 'text', 'readed'];
}
