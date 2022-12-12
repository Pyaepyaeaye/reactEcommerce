<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductApiController extends Controller
{
    public function detail($slug){
        $product = Product::where('slug', $slug)
                    ->with('review.user', 'brand', 'category', 'color', 'size')
                    ->first();
        return response()->json([
            'message' => 'true',
            'data' => $product,
        ]);
        
    }
}
