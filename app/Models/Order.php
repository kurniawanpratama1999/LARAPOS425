<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'payment',
        'payment_tool',
        'payment_detail',
        'quantities',
        'subtotal',
        'tax',
        'discount',
        'total',
    ];

    public function user () {
        return $this->belongsTo(User::class);
    }
    
    public function orderDetails () {
        return $this->hasMany(OrderDetail::class);
    }
}
