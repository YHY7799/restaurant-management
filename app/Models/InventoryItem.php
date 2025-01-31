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
        'stock_quantity',
        'storage_unit',
        'usage_unit',
        'conversion_factor'
    ];

    // Convert stock to usage units
    public function getAvailableInUsageAttribute()
    {
        return $this->stock_quantity * $this->conversion_factor;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity_used')
            ->withTimestamps();
    }
}
