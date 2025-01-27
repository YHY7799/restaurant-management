<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'image_path'];


    public function Product()
    {
        return $this->belongsTo(Product::class);
    }
}
