<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\ProductCart;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartApiController extends Controller
{
    public function addToCart(Request $request, $slug){
        $product = Product::where('slug', $slug)->first();
        if(!$product){
            return response()->json([
                'message' => false,
                'data'=> "Product Not Found",
            ]);
        }
        $find_cart = ProductCart::where('user_id',$request->user_id)
        ->where('product_id', $product->id)->first();
        if($find_cart){
            $qty= $find_cart->total_qty +1;
            $find_cart->update([
                'total_qty' => $qty
            ]);
        }else{
            $product_cart_create= ProductCart::create([
                'user_id' => $request->user_id,
                'product_id' => $product->id,
                'total_qty' => 1,
            ]);
        }
        $cart_count= ProductCart::where('user_id', $request->user_id)->count();
        return response()->json([
            'message' => true,
            'data'=> $cart_count,
        ]);        
    }

    public function getCart(){
        $user_id = request()->user_id;
        $cart= ProductCart::where('user_id', $user_id)->with('product')->get();
        return response()->json([
            'message' => true,
            'data' => $cart
        ]);


    }

    public function getUpdateCartQty(){
        $cart_id= request()->cart_id;
        $qty = request()->total_qty;
        ProductCart::where('id', $cart_id)->update([
            'total_qty' => $qty
        ]);
        return response()->json([
            'message' => true,
            'data' => null
        ]);
    }
    public function removeCart(){
        $cart_id= request()->cart_id;      
        ProductCart::where('id', $cart_id)->delete();
        return response()->json([
            'message' => true,
            'data' => null
        ]);
    }

    public function checkout() {
        $user_id = request()->user_id;
        $carts = ProductCart::where('user_id', $user_id)->get();
        foreach($carts as $cart){
            ProductOrder::create([
                'user_id' => $cart->user_id,
                'product_id' => $cart->product_id,
                'total_qty' => $cart->total_qty
            ]);
        }
        ProductCart::where('user_id', $user_id)->delete();
        return response()->json([
            'message' => true,
            'data' => $carts
        ]);
    }

    public function orderList() {
        $user_id = request()->user_id;
        $order = ProductOrder::where('user_id', $user_id)
        ->with('product')
        ->paginate(1);
        return response()->json([
            'message' => true,
            'data' => $order
        ]);
    }
}
