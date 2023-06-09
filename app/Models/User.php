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
        'order_id',
        'stripe_connect_id',
        'completed_stripe_onboarding',
        'username',
        'memory_limit',
        'image',
        'email',
        'password',
        'status',
        'forgot_password_code',
        'twitter',
        'instagram',
        'facebook',
        'subscription_price_id'
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
    
    public function products()
    {
        return $this->hasMany(Product::class, 'user_id', 'id')->orderBy('id', 'DESC');
    }

    public function subscribers()
    {
        return $this->hasMany(UserSubscribers::class, 'user_id', 'id');
    }
    
    public function views()
    {
        $podcasts = $this->podcasts();
        $podcasts_ids = [];
        foreach ($podcasts as $podcast) {
           array_push($podcasts_ids, $podcast->id);
        }
        return Views::whereIn('podcast_id', $podcasts_ids);
    }

    public function SubscriptionInfo()
    {
        return $this->hasOne(SubscriptionPrice::class, 'id', 'subscription_price_id');
    }



}
