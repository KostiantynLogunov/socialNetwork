<?php

namespace Chatty;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'statuses';

    protected $fillable = ['body'];

    public function user() {
        return $this->belongsTo('Chatty\User', 'user_id');
    }

    public function scopeNotReply($query) {
        return $query->whereNull('parent_id');
    }

    public function replies() {
        return $this->hasMany('Chatty\Status', 'parent_id');
    }

    public function likes() {
        return $this->morphMany('Chatty\Like', 'likeable');
    }
}
