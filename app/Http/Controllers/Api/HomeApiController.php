<?php

namespace App\Http\Controllers\Api;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeApiController extends Controller
{
    public function home() {
        $category = Category::withCount('product')->get();
        $feature_product_data = Product::all();        
        if($feature_product_data->count() > 4){
            $feature_product = Product::all()->random(4);
        }
        else{
            $feature_product = $feature_product_data;
        } 
        $productByCategory = Category::has('product')->take(2)->get();
        foreach($productByCategory as $k=>$v){
            $productByCategory[$k]->product = Product::where('category_id', $v->id)->take(6)->get();

        }       
                
        return response()->json([
            'success' => true,
            'data' => [
                'category' => $category,
                'featureProduct' => $feature_product,
                'productByCategory' => $productByCategory,
            ]
        ]);
      
    }
    
}
