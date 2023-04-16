<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;

class SubscriptionPayout extends Model
{
    use HasFactory, Billable;
    protected $table = 'subscription_payout';
    protected $fillable = [
        'user_id',
        'price',
        'payout'
    ];


}
