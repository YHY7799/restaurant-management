<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'description', 'active', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function Images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function inventoryItems()
{
    return $this->belongsToMany(InventoryItem::class)
        ->withPivot('quantity_used')
        ->withTimestamps();
}

public function calculateCost()
{
    return $this->inventoryItems->sum(function ($item) {
        if ($item->conversion_factor <= 0) {
            return 0; // Prevent division by zero errors
        }

        // Convert quantity used to storage unit and multiply by the cost per storage unit
        return ($item->pivot->quantity_used / $item->conversion_factor) * $item->cost_per_unit;
    });
}

public function formattedCost()
{
    return number_format($this->calculateCost(), 2);
}

// Ensure total cost calculation also considers the conversion factor
public function getTotalCostAttribute()
{
    return $this->calculateCost();
}



    protected static function booted()
    {
        static::deleting(function ($product) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
        });
    }
}
