<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'role',
        'belongs_to',
        'username',
        'image',
        'email',
        'password',
        'status',
        'forgot_password_code',
        'twitter',
        'instagram',
        'facebook'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    public function podcasts()
    {
        return $this->hasMany(Podcast::class)->orderBy('id', 'DESC');
    }

    public function subscribers()
    {
        return $this->hasMany(UserSubscribers::class, 'user_id', 'id');
    }



}
