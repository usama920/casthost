<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPrice extends Model
{
    use HasFactory;
    protected $table = "subscription_price";
    protected $fillable = [
        'id',
        'subscriber_id',
        'price_id',
        'product_id',
        'price',
        'status'
    ];
}
