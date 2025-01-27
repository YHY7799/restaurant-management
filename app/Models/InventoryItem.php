<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryItem extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'cost_per_unit',
        'stock_quantity'
    ];

    public function products()
{
    return $this->belongsToMany(Product::class, 'inventory_item_product')
        ->withPivot('quantity')
        ->withTimestamps();
}

}
