<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\OrderStatus;

class Order extends Model
{
    protected $fillable = ['customer_id', 'order_number', 'status', 'total_amount'];

    protected $casts = [
        'status' => OrderStatus::class, 
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
