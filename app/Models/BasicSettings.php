<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicSettings extends Model
{
    use HasFactory;
    protected $fillable = [
        'site_title',
        'site_logo',
        'admin_logo',
        'email',
        'twitter',
        'instagram',
        'facebook',
        'phone',
        'store_commission',
        'subscription_commission',
        'stripe_transaction_fee',
        'stripe_transaction_commission'
    ];
}
