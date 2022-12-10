<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::latest()->paginate(5);
        return view('admin.category.index',compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');       
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
            'mm_name' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
        ],[
            'name.required' => 'Category Name is required',
            'mm_name.required' => "Category MM Name is required",
            'image.required' => 'Image is required',
        ]);
        if($v->fails()){
            return redirect()->back()->withErrors($v->errors());
        }
        $image = $request->file('image');
        $img_name= uniqid(). $image->getClientOriginalName();
        $image->move(public_path('/images/category/'), $img_name);

        Category::create([
            'slug' => Str::slug($request->name).uniqid(),
            'name' => $request->name,
            'mm_name' => $request->mm_name,
            'image' => $img_name,
            
        ]);
        return redirect('/admin/category')->with('success',"Category Create Successfully");    
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
        $cat = Category::where('slug', $id)->first();   
        return view('admin.category.edit', compact('cat'));
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
        
        $find_category= Category::where('id', $id)->first();   
           
        if($request->name !=  $find_category->name){
            $slug = uniqid(). Str::slug($request->name);
        }
        if($request->name ==  $find_category->name){
            $slug =  $find_category->slug;
        }
        //image store 
        $image= $request->file('image');       
        
        if($image){
            File::delete(public_path('/images/category/'.$find_category->image));
            $new_image = uniqid(). $image->getClientOriginalName();
            $image->move(public_path('/images/category/'), $new_image);   
        }  
        else{            
            $new_image = $find_category->image;
        }        
        $find_category->update([           
            'slug' => $slug,
            'name' => $request->name,
            'mm_name' => $request->mm_name,
            'image' => $new_image,           
        ]);       
        return redirect('/admin/category')->with('success',"Category Update Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {      
        $category= Category::find($id)->delete();
        return redirect()->back();
    }

    public function restoreAll(){
        
        Category::onlyTrashed()->restore();
        return redirect()->back()->with('success', 'Category are restored..');
    }
}
