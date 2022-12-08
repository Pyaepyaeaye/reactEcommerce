<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ProductAddTransaction;
use Illuminate\Support\Facades\File; 

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::latest()->select('id','slug','name','image','total_qty')->paginate(10);
        return view('admin.product.index',compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();
        $supplier = Supplier::all();
        $color = Color::all();
        $brand = Brand::all();
        return view('admin.product.create',compact('category','supplier','color','brand'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $v= Validator::make($request->all(),[
            'name' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
            'total_qty'=> 'required|integer',
            'buy_price'=>'required|integer',
            'sale_price'=> 'required|integer',
            'discount_price'=> 'required|integer',
            'supplier_slug'=> 'required|string',
            'category_slug'=> 'required|string',
            'color_slug.*'=> 'required|string',
            'brand_slug'=> 'required|string',
        ],[
            'name.required' => 'Prouduct Name is required',
            'image.required' => 'Image is required',
            'total_qty.required' => 'Quantity is required',
            'buy_price.required' => 'Buy Price is required',
            'sale_price.required' => 'Sale Price is required',
            'discount_price.required' => 'Discount Price is required',
            'supplier_slug.required' => 'Supplier is required',
            'category_slug.required' => 'Category is required',
            'color_slug.required' => 'Color is required',
            'brand_slug.required' => 'Brand is required',
            'color_slug.required' => 'Color is required',
        ]);
        if($v->fails()){
            return redirect()->back()->withErrors($v->errors());
        }
       
        //image store         
        //$img_name = time().'.'.$request->image->extension();
        $image= $request->file('image');     
        $img_name = time().'__'.$image->getClientOriginalName();
        $image->move(public_path('images'), $img_name );      
        //product store
        $product= Product::create([
            'category_id' => $request->category_slug,
            'supplier_id' => $request->supplier_slug,
            'brand_id' => $request->brand_slug,
            'slug' => uniqid(). Str::slug($request->name),
            'name' => $request->name,
            'image' => $img_name,
            'discount_price' =>$request->discount_price,
            'buy_price' =>$request->buy_price,
            'sale_price' =>$request->sale_price,
            'total_qty' =>$request->total_qty,
            'like_count' => 0,
            'view_count' => 0,
            'description' => $request->description,
            'color_slug' => $request->color_slug,
        ]);

        //add transaction
        ProductAddTransaction::create([
            'product_id' => $product->id,
            'supplier_id' => $request->supplier_slug,
            'total_qty' => $request->total_qty,
        ]);

        //add color
        $p= Product::find($product->id);        
        $p->color()->sync($request->color_slug);
        return redirect('/admin/product')->with('success',"Product Create Successfully");    

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::all();
        $supplier = Supplier::all();
        $color = Color::all();
        $brand = Brand::all();
        $product = Product::where('slug', $id)->first();   
        return view('admin.product.edit',compact('category','supplier','color','brand','product'));
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $find_product= Product::find($id)->first();

        //image store 
        $image= $request->file('image');
        $new_imag='';
        if($image){
            File::delete(public_path('images/'.$find_product->image));
            $new_imag = time().'__'.$image->getClientOriginalName();
            $image->move(public_path('images'), $new_imag);   
        }  
        else{            
            $new_imag= $find_product->image;
        } 
        $slug = uniqid(). Str::slug($request->name);
        //product store
        $find_product->update([
            'category_id' => $request->category_slug,
            'supplier_id' => $request->supplier_slug,
            'brand_id' => $request->brand_slug,
            'slug' => $slug,
            'name' => $request->name,
            'image' => $new_imag,
            'discount_price' =>$request->discount_price,
            'buy_price' =>$request->buy_price,
            'sale_price' =>$request->sale_price,
            'total_qty' =>$request->total_qty,
            'like_count' => 0,
            'view_count' => 0,
            'description' => $request->description,
            'color_slug' => $request->color_slug,
        ]);

        //add transaction
        // ProductAddTransaction::create([
        //     'product_id' => $product->id,
        //     'supplier_id' => $request->supplier_slug,
        //     'total_qty' => $request->total_qty,
        // ]);
        //add color               
        $find_product->color()->sync($request->color_slug);
        return redirect(route('product.edit', $slug))->with('success', "Product Update Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id)->delete();
        return redirect()->back();
    }

    public function imageUpload() {
        $file= request()->file('image');
        $file_name= uniqid() . $file->getClientOriginalName();
        $file->move(public_path('/images'), $file_name);
        return asset('/images/'.$file_name);
    }

    public function restoreAll(){        
        Product::onlyTrashed()->restore();
        return redirect()->back()->with('success', 'Product are restored..');
    }
    public function productAdd($slug) {
        $product = Product::where('slug', $slug)->first();
        $supplier = Supplier::all();
        return view('admin.product.product-add',compact('supplier','product'));

    }
    public function storeProductAdd(Request $request,$id) {
        ProductAddTransaction::create([
            'supplier_id' => $request->supplier_slug,
            'product_id' => $id,
            'total_qty' => $request->total_qty,
            'description' => $request->description
        ]);
        $product=Product::find($id)->first();
        $product->update([
            'total_qty'=> DB::raw('total_qty+'. $request->total_qty)
        ]);
        return redirect(route('product.index'))->with('success',$request->total_qty.' added Successfully');

    }
    public function AddTransaction() {
        $transaction = ProductAddTransaction::with('product')->paginate(10);
        
        return view('admin.product.product-add-transaction',compact('transaction'));
    }


    public function productRemove($slug) {

    }
}
