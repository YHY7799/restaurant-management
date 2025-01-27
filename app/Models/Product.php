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
        return $this->belongsToMany(InventoryItem::class, 'inventory_item_product')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function getTotalCostAttribute()
    {
        return $this->inventoryItems->sum(function ($item) {
            return $item->pivot->quantity * $item->cost_per_unit;
        });
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
