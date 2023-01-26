<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Size;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
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

    public function product(){
        $category = Category::withCount('product')->get();        
        $color = Color::all();
        $brand = Brand::all();
        $size = Size::all();
        $product = Product::latest(); 

        if(request()->category || request()->color || request()->size){
          
            $category_find = Category::where('name', request()->category)->first();  
            $color_find = Color::where('name', request()->color)->first();       
            $size_find = Size::where('name', request()->size)->first();         
            if($category_find){                   
                $product->where('category_id', $category_find->id);
            }
            if($color_find){
               $product->whereHas('color', function($q) use($color_find){
                $q->where('product_color.color_id', $color_find->id);
               });
           
            }
            if($size_find){
                $product->whereHas('size', function($s) use($size_find){
                    $s->where('product_size.size_id', $size_find->id);
                });
            }
            if( !$color_find || !$size_find || !$category_find){
                return redirect('/shop')->with('error','Product not found');
            }
            else{
                return redirect('/shop')->with('error','Product not found');
            }
           
        }

        $product= $product->paginate(10);   

        return view('product',compact('category','color','brand','product','size'));
    }
}
