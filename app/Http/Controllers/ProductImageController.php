<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;


class ProductImageController extends Controller
{
    public function destroy(ProductImage $productImage)
{
    Storage::disk('public')->delete($productImage->image_path);
    $productImage->delete();
    
    return back()->with('success', 'Image deleted successfully');
}
}
