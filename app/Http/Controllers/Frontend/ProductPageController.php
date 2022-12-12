<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductPageController extends Controller
{
    public function detail($slug){
        $product = Product::where('slug', $slug)->first();
        if(!$product){
            return redirect('/')->with('error', "product Not Found");
        }
        else{
            return view('product-detail',compact('slug'));
        }
        
    }
}
