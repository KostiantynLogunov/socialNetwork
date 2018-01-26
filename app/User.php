<?php

namespace Chatty;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'first_name', 'last_name', 'location'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getName() {
        if ($this->first_name && $this->last_name) {
            return "{$this->first_name} {$this->last_name}";
        }

        if ($this->first_name) {
            return $this->first_name;
        }
        return null;
    }

    public function getNameOrUserName() {
        return $this->getName() ?: $this->username;
    }

    public function getFirstNameOrUserName() {
        return $this->first_name ?: $this->username;
    }

    public function getAvatarUrl() {
        return "https://www.gravatar.com/avatar/{{ md5($this->>email)}}?d=mm&s=40";
    }

    public function statuses() {
        return $this->hasMany('Chatty\Status', 'user_id');
    }

    public function likes() {
        return $this->hasMany('Chatty\Like', 'user_id');
    }

    public function friendsOfMine(){
        return $this->belongsToMany('Chatty\User', 'friends', 'user_id', 'friend_id');
    }


    public function friendOf() {
        return $this->belongsToMany('Chatty\User', 'friends', 'friend_id', 'user_id');
    }

    public function friends(){
        return $this->friendsOfMine()->wherePivot('accepted', true)->get()
                    ->merge($this->friendOf()->wherePivot('accepted', true)->get());
    }

    public function friendRequest() {
        return $this->friendsOfMine()->wherePivot('accepted',false)->get();
    }

    public function friendRequestPending() {
        return $this->friendOf()->wherePivot('accepted',false)->get();
    }

    public function hasfriendRequestPending(User $user) {
        return (bool)$this->friendRequestPending()->where('id',$user->id)->count();
    }

    public function hasfriendRequestReceived(User $user) {
        return (bool)$this->friendRequest()->where('id',$user->id)->count();
    }

    public function addfriend(User $user) {
        return $this->friendOf()->attach($user->id);
    }

    public function deleteFriend(User $user) {
        return $this->friendOf()->detach($user->id);
        return $this->friendsOfMine()->detach($user->id);
    }

    public function acceptFriendRequest(User $user) {
        return $this->friendRequest()->where('id', $user->id)->first()->pivot->update(['accepted'=>true]);
    }

    public function isFriendWith(User $user) {
        return (bool)$this->friends()->where('id' , $user->id)->count();
    }

    public function hasLikedStatus(Status $status) {
        return (bool)$status->likes->where('user_id', $this->id)->count();
        /*return $status->likes
            ->where('likeable_id', $status->id)
            ->where('likeable_type', get_class($status))
            ->where('user_id', $this->id)
            ->count();*/
    }
}
