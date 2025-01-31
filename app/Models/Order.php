<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['customer_id', 'order_number', 'status', 'total_amount'];

    public function customer()
    {
        return $this->belongsTo(Customer::class)->withDefault([
            'name' => 'Guest Customer', // Default value if no customer is associated
        ]);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
