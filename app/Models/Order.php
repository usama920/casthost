<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'first_name',
        'last_name',
        'country',
        'street_address',
        'city',
        'state',
        'zip',
        'phone',
        'notes',
        'price',
        'status'
    ];

    public function order_items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
    
    public function subscriber()
    {
        return $this->hasOne(Subscribers::class, 'id', 'subscriber_id');
    }
}
