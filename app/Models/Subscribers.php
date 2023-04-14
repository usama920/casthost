<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;

class Subscribers extends Model
{
    use HasFactory, Billable;
    protected $table = 'subscribers';
    protected $fillable = [
        'email',
        'code',
        'status',
        'admin_status',
    ];


}
