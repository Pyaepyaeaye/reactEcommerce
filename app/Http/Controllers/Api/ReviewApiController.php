<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Http\Controllers\Controller;

class ReviewApiController extends Controller
{
    public function makeReview(Request $request, $slug){
        $product = Product::where('slug', $slug)->first();
        if(!$product){
            return response()->json([
                'message' => false,
                'data' => "slug Not Found"
            ]);
        }
        $reiview = ProductReview::create([
            'user_id' => $request->user_id,
            'product_id' => $product->id,
            'review' => $request->comment,
            'rating' => $request->rating,
        ]);
        $reiview_data = ProductReview::where('id', $reiview->id)->with('user')->first();
        return response()->json([
            'message' => true,
            'data' => $reiview_data
        ]);
    }
}
